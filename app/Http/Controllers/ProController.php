<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientProtocol;
use App\Models\Program;
use App\Models\ProUser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProController extends Controller
{
    public function index()
    {
        return Inertia::render('Pro/Index');
    }

    public function dashboard()
    {
        $user    = auth()->user();
        $pro     = $user->proProfile;
        $patients = Patient::with('protocols.program')
            ->where('pro_user_id', $pro->id)->latest()->get();
        $programs = Program::with('category')->where('is_active', true)->get();

        $stats = [
            'patients_count'    => $patients->count(),
            'protocols_active'  => PatientProtocol::whereIn('patient_id', $patients->pluck('id'))->where('status','assigned')->count(),
            'commission_total'  => $pro->total_commissions,
            'commission_rate'   => $pro->commission_rate,
        ];

        return Inertia::render('Pro/Dashboard', compact('patients','programs','stats','pro'));
    }

    public function storePatient(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        $pro = auth()->user()->proProfile;
        Patient::create([
            'pro_user_id'    => $pro->id,
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'age'            => $request->age,
            'gender'         => $request->gender,
            'medical_history'=> $request->medical_history,
        ]);

        return back()->with('success', 'Patient ajouté.');
    }

    public function assignProtocol(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'program_id' => 'required|exists:programs,id',
        ]);

        PatientProtocol::create([
            'patient_id' => $request->patient_id,
            'program_id' => $request->program_id,
            'notes'      => $request->notes,
            'status'     => 'assigned',
        ]);

        return back()->with('success', 'Protocole assigné au patient.');
    }

    public function updateProtocol(Request $request, PatientProtocol $protocol)
    {
        $protocol->update($request->only('status','sessions_done','progress_percent','notes'));
        return back()->with('success', 'Protocole mis à jour.');
    }
}
