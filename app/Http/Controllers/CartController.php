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
            $program = Program::find($id);
            if ($program) {
                $items[] = ['program' => $program, 'quantity' => $item['quantity']];
                $total += $program->price * $item['quantity'];
            }
        }

        return Inertia::render('Cart', compact('items', 'total'));
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
        unset($cart[$request->program_id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Programme retiré du panier.');
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
