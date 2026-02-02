<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

     use RefreshDatabase;

    public function test_user_can_pay_for_order()
    {
        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => 500,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/payments', [
                'order_id' => $order->id,
                'payment_method' => 'credit_card',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'payment_method' => 'credit_card',
            'status' => 'successful',
        ]);
    }
}

