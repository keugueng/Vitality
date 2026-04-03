<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\UserProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $programs = UserProgram::with('program.category')
            ->where('user_id', $user->id)
            ->latest()->get();

        $orders = Order::where('user_id', $user->id)
            ->with('items.program')
            ->latest()->take(5)->get();

        $subscription = $user->activeSubscription();

        return Inertia::render('Dashboard/Index', compact('programs','orders','subscription'));
    }

    public function profile()
    {
        return Inertia::render('Dashboard/Profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($request->only('name','phone'));
        return back()->with('success', 'Profil mis à jour.');
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.program')
            ->latest()->paginate(10);
        return Inertia::render('Dashboard/Orders', compact('orders'));
    }
}
