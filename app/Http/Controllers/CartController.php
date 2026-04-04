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
        $packages = [
            'single'    => ['name' => 'Consultation Essentielle',    'sessions' => 1, 'price' => 58],
            'progress'  => ['name' => 'Consultation Évolution',      'sessions' => 3, 'price' => 149],
            'transform' => ['name' => 'Consultation Transformation', 'sessions' => 5, 'price' => 239],
        ];

        $pkgId = $request->input('package_type', 'single');
        $pkg   = $packages[$pkgId] ?? $packages['single'];

        $cart = session('cart', []);
        $key  = 'consult_' . $pkgId;
        $cart[$key] = array_merge($pkg, ['package_type' => $pkgId]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', "«{$pkg['name']}» ajouté au panier.");
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
