<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Program;
use App\Models\Setting;
use App\Models\UserProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Votre panier est vide.');
        }

        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $program = Program::find($id);
            if ($program) {
                $items[] = ['program' => $program, 'quantity' => $item['quantity']];
                $total += $program->price * $item['quantity'];
            }
        }

        $paymentConfig = [
            'stripe_enabled'    => Setting::get('stripe_enabled', '1') === '1',
            'paypal_enabled'    => Setting::get('paypal_enabled', '0') === '1',
            'paypal_client_id'  => Setting::get('paypal_client_id', ''),
            'paypal_email'      => Setting::get('paypal_email', ''),
        ];

        return Inertia::render('Checkout', compact('items', 'total', 'paymentConfig'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:30',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop');
        }

        $subtotal = 0;
        $cartItems = [];
        foreach ($cart as $id => $item) {
            $program = Program::find($id);
            if ($program) {
                $cartItems[] = ['program' => $program, 'quantity' => $item['quantity']];
                $subtotal += $program->price * $item['quantity'];
            }
        }

        $order = Order::create([
            'user_id'        => auth()->id(),
            'order_number'   => 'VIT-' . strtoupper(Str::random(8)),
            'customer_name'  => $request->name,
            'customer_email' => $request->email,
            'subtotal'       => $subtotal,
            'total'          => $subtotal,
            'status'         => 'completed',
            'payment_method' => $request->input('payment_method', 'stripe'),
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id'      => $order->id,
                'program_id'    => $cartItem['program']->id,
                'program_title' => $cartItem['program']->title,
                'price'         => $cartItem['program']->price,
                'quantity'      => $cartItem['quantity'],
            ]);

            if (auth()->check()) {
                UserProgram::firstOrCreate([
                    'user_id'    => auth()->id(),
                    'program_id' => $cartItem['program']->id,
                ], [
                    'order_id'    => $order->id,
                    'access_link' => url('/my-program/' . $cartItem['program']->slug),
                ]);
            }
        }

        session()->forget('cart');

        return redirect()->route('checkout.success', $order)->with('success', 'Commande confirmée !');
    }

    public function success(Order $order)
    {
        $order->load('items.program');
        return Inertia::render('CheckoutSuccess', compact('order'));
    }
}
