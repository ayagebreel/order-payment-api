<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index(Request $request){
        $query = Order::query();

        if($request->has('status')){
            $query->where('status',$request->status);
        }

        return response()->json($query->with('items','payments')->paginate(10));
    }

    public function show($id){
        $order = Order::with('items','payments')->findOrFail($id);
        return response()->json($order);
    }

    public function store(Request $request){
        $request->validate([
            'items'=>'required|array|min:1',
            'items.*.product_name'=>'required|string',
            'items.*.quantity'=>'required|integer|min:1',
            'items.*.price'=>'required|numeric|min:0',
        ]);

        $total = 0;
        foreach($request->items as $item){
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id'=>auth()->id(),
            'status'=>'pending',
            'total_amount'=>$total
        ]);

        foreach($request->items as $item){
            OrderItem::create([
                'order_id'=>$order->id,
                'product_name'=>$item['product_name'],
                'quantity'=>$item['quantity'],
                'price'=>$item['price'],
                'subtotal'=>$item['quantity'] * $item['price']
            ]);
        }

        return response()->json($order->load('items'),201);
    }

    public function update(Request $request,$id){
        $order = Order::findOrFail($id);
        if($order->payments()->count() > 0){
            return response()->json(['error'=>'Cannot update order with payments'],400);
        }

        $order->update($request->only('status'));
        return response()->json($order);
    }

    public function destroy($id){
        $order = Order::findOrFail($id);
        if($order->payments()->count() > 0){
            return response()->json(['error'=>'Cannot delete order with payments'],400);
        }
        $order->delete();
        return response()->json(['message'=>'Order deleted']);
    }
}

