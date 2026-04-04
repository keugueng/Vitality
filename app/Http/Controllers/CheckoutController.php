<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Program;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\UserProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            if (str_starts_with($id, 'consult_')) {
                $items[] = [
                    'type'    => 'consultation',
                    'key'     => $id,
                    'consult' => $item,
                    'quantity' => 1,
                ];
                $total += $item['price'];
                continue;
            }
            if (str_starts_with($id, 'sub_')) {
                $items[] = [
                    'type'    => 'subscription',
                    'key'     => $id,
                    'sub'     => $item,
                    'quantity' => 1,
                ];
                $total += $item['price'];
                continue;
            }
            $program = Program::find($id);
            if ($program) {
                $items[] = ['type' => 'program', 'program' => $program, 'quantity' => $item['quantity']];
                $total += $program->price * $item['quantity'];
            }
        }

        $paymentConfig = [
            'stripe_enabled'    => true,
            'paypal_enabled'    => true,
            'paypal_client_id'  => Setting::get('paypal_client_id', ''),
            'paypal_email'      => Setting::get('paypal_email', 'paypal@vitalityinside.com'),
        ];

        return Inertia::render('Checkout', compact('items', 'total', 'paymentConfig'));
    }

    public function process(Request $request)
    {
        $cart = session('cart', []);

        $hasConsultation = collect($cart)->keys()->contains(fn($k) => str_starts_with($k, 'consult_'));

        if (empty($cart)) {
            return redirect()->route('shop');
        }

        $rules = [
            'name'               => 'required|string|max:255',
            'email'              => 'required|email',
            'phone'              => 'nullable|string|max:30',
            'payment_method'     => 'required|in:stripe,paypal',
            'payment_intent_id'  => 'nullable|string',
            'paypal_order_id'    => 'nullable|string',
        ];
        if ($hasConsultation) {
            $rules['symptoms']        = 'required|string|min:10';
            $rules['medical_history'] = 'nullable|string';
        }
        $request->validate($rules);

        // ── Verify Stripe payment ──────────────────────────────────────────
        if ($request->payment_method === 'stripe') {
            if (!$request->payment_intent_id) {
                return back()->withErrors(['payment' => 'Identifiant de paiement Stripe manquant.']);
            }
            $mode      = Setting::get('stripe_mode', 'test');
            $secretKey = $mode === 'live' ? Setting::get('stripe_sk_live') : Setting::get('stripe_sk_test');
            if ($secretKey) {
                \Stripe\Stripe::setApiKey($secretKey);
                $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);
                if ($intent->status !== 'succeeded') {
                    return back()->withErrors(['payment' => 'Le paiement Stripe n\'a pas été confirmé.']);
                }
            }
        }

        // ── Verify PayPal payment ──────────────────────────────────────────
        if ($request->payment_method === 'paypal') {
            if (!$request->paypal_order_id) {
                return back()->withErrors(['payment' => 'Identifiant de commande PayPal manquant.']);
            }
        }

        $subtotal = 0;
        $cartItems = [];
        foreach ($cart as $id => $item) {
            if (str_starts_with($id, 'consult_')) {
                $cartItems[] = ['type' => 'consultation', 'key' => $id, 'consult' => $item];
                $subtotal += $item['price'];
                continue;
            }
            if (str_starts_with($id, 'sub_')) {
                $cartItems[] = ['type' => 'subscription', 'key' => $id, 'sub' => $item];
                $subtotal += $item['price'];
                continue;
            }
            $program = Program::find($id);
            if ($program) {
                $cartItems[] = ['type' => 'program', 'program' => $program, 'quantity' => $item['quantity']];
                $subtotal += $program->price * $item['quantity'];
            }
        }

        $paymentRef = $request->payment_intent_id ?? $request->paypal_order_id ?? 'manual';

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
            if ($cartItem['type'] === 'consultation') {
                $c = $cartItem['consult'];
                OrderItem::create([
                    'order_id'      => $order->id,
                    'program_id'    => null,
                    'program_title' => $c['name'],
                    'price'         => $c['price'],
                    'quantity'      => 1,
                ]);
                $consultation = Consultation::create([
                    'user_id'         => auth()->id(),
                    'name'            => $request->name,
                    'email'           => $request->email,
                    'phone'           => $request->phone ?? '',
                    'package_type'    => $c['package_type'],
                    'sessions_count'  => $c['sessions'],
                    'amount'          => $c['price'],
                    'status'          => 'pending',
                    'payment_status'  => 'paid',
                    'payment_intent'  => 'order-' . $order->order_number,
                    'symptoms'        => $request->symptoms ?? '',
                    'medical_history' => $request->medical_history ?? '',
                ]);
                // Notify admin about new consultation
                $adminEmail = Setting::get('admin_email', config('mail.from.address', 'admin@vitalityinside.com'));
                try {
                    Mail::send('mail.consultation-ordered', [
                        'consultation' => $consultation,
                        'order'        => $order,
                    ], function ($msg) use ($adminEmail, $consultation) {
                        $msg->to($adminEmail)
                            ->subject('Nouvelle consultation #' . $consultation->id . ' — ' . $consultation->name);
                    });
                } catch (\Throwable $e) {
                    \Log::warning('Admin consultation email failed: ' . $e->getMessage());
                }
                continue;
            }
            if ($cartItem['type'] === 'subscription') {
                $s = $cartItem['sub'];
                $plan = str_replace('sub_', '', $cartItem['key']);
                $endsAt = $plan === 'monthly' ? now()->addMonth() : now()->addYear();
                Subscription::create([
                    'user_id'        => auth()->id(),
                    'type'           => $plan,
                    'price'          => $s['price'],
                    'status'         => 'active',
                    'payment_intent' => 'order-' . $order->order_number,
                    'starts_at'      => now(),
                    'ends_at'        => $endsAt,
                ]);
                continue;
            }
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
