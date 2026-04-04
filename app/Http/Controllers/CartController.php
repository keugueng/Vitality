<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            if (str_starts_with($id, 'consult_')) {
                $items[] = [
                    'type'     => 'consultation',
                    'key'      => $id,
                    'program'  => null,
                    'consult'  => $item,
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

        return Inertia::render('Cart', compact('items', 'total'));
    }

    public function addConsultation(Request $request)
    {
        $request->validate(['package_type' => 'required|in:single,progress,transform']);
        $pkg = [
            'single'    => ['name' => 'Consultation unique', 'sessions' => 1, 'price' => 58,  'package_type' => 'single'],
            'progress'  => ['name' => 'Consultation progression (3 séances)', 'sessions' => 3, 'price' => 149, 'package_type' => 'progress'],
            'transform' => ['name' => 'Consultation transformation (5 séances)', 'sessions' => 5, 'price' => 239, 'package_type' => 'transform'],
        ][$request->package_type];
        $cart = session('cart', []);
        $cart["consult_{$request->package_type}"] = $pkg;
        session(['cart' => $cart]);
        return redirect()->route('checkout')->with('success', 'Consultation ajoutée au panier.');
    }

    public function addSubscription(Request $request)
    {
        $request->validate(['plan' => 'required|in:monthly,annual']);
        $plans = [
            'monthly' => ['name' => 'Abonnement Mensuel Illimité', 'price' => 29.90, 'period' => 'month'],
            'annual'  => ['name' => 'Abonnement Annuel Illimité', 'price' => 249, 'period' => 'year'],
        ];
        $plan = $plans[$request->plan];
        $cart = session('cart', []);
        // Only one subscription at a time
        $cart = array_filter($cart, fn($k) => !str_starts_with($k, 'sub_'), ARRAY_FILTER_USE_KEY);
        $cart["sub_{$request->plan}"] = $plan;
        session(['cart' => $cart]);
        return back()->with('success', 'Abonnement ajouté au panier.');
    }

    public function add(Request $request)
    {
        $program = Program::findOrFail($request->program_id);
        $cart = session('cart', []);

        if (isset($cart[$program->id])) {
            $cart[$program->id]['quantity']++;
        } else {
            $cart[$program->id] = ['quantity' => 1];
        }

        session(['cart' => $cart]);

        return back()->with('success', "«{$program->title}» ajouté au panier.");
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        $key  = $request->cart_key ?? $request->program_id;
        unset($cart[$key]);
        session(['cart' => $cart]);

        return back()->with('success', 'Article retiré du panier.');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        if (isset($cart[$request->program_id])) {
            if ($request->quantity <= 0) {
                unset($cart[$request->program_id]);
            } else {
                $cart[$request->program_id]['quantity'] = $request->quantity;
            }
        }
        session(['cart' => $cart]);
        return back();
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Panier vidé.');
    }
}
