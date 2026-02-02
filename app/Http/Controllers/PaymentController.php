<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Payments\PaymentGatewayManager;

class PaymentController extends Controller
{
    public function index(){
        return response()->json(Payment::with('order')->paginate(10));
    }

    public function orderPayments($orderId){
        $order = Order::findOrFail($orderId);
        return response()->json($order->payments);
    }

    public function processPayment(Request $request){
        $request->validate([
            'order_id'=>'required|exists:orders,id',
            'payment_method'=>'required|in:credit_card,paypal'
        ]);

        $order = Order::findOrFail($request->order_id);

        if($order->status !== 'confirmed'){
            return response()->json(['error'=>'Payments allowed only for confirmed orders'],400);
        }

        $gateway = new PaymentGatewayManager();
        $result = $gateway->resolve($request->payment_method)->process($order->total_amount);

        $payment = Payment::create([
            'order_id'=>$order->id,
            'payment_method'=>$request->payment_method,
            'status'=>$result['status'],
            'reference'=>$result['reference']
        ]);

        return response()->json($payment,201);
    }
}
