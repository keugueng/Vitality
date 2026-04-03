<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email',
            'symptoms'     => 'required|string|min:20',
            'package_type' => 'required|in:single,progress,transform',
        ]);

        $amounts = ['single' => 58, 'progress' => 149, 'transform' => 239];
        $sessions = ['single' => 1, 'progress' => 3, 'transform' => 5];

        Consultation::create([
            'user_id'       => auth()->id(),
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'package_type'  => $request->package_type,
            'sessions_count'=> $sessions[$request->package_type],
            'amount'        => $amounts[$request->package_type],
            'symptoms'      => $request->symptoms,
            'medical_history' => $request->medical_history,
        ]);

        return back()->with('success', 'Votre consultation a été réservée. Vous recevrez votre protocole sous 8 heures.');
    }
}
