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
        $user = auth()->user();

        // Auto-create proProfile if user is pro but profile missing
        $pro = $user->proProfile ?? ProUser::firstOrCreate(
            ['user_id' => $user->id],
            ['commission_rate' => 20, 'total_commissions' => 0, 'status' => 'active']
        );

        // Mark user as pro if not already
        if (!$user->is_pro) {
            $user->update(['is_pro' => true]);
        }

        $patients = Patient::with('protocols.program')
            ->where('pro_user_id', $pro->id)->latest()->get();
        $programs = Program::with('category')->where('is_active', true)->get();

        $stats = [
            'patients_count'   => $patients->count(),
            'protocols_active' => PatientProtocol::whereIn('patient_id', $patients->pluck('id'))->where('status','assigned')->count(),
            'commission_total' => number_format($pro->total_commissions ?? 0, 2),
            'commission_rate'  => $pro->commission_rate ?? 20,
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

    public function patients()
    {
        $user = auth()->user();
        $pro  = $user->proProfile ?? ProUser::firstOrCreate(
            ['user_id' => $user->id],
            ['commission_rate' => 20, 'total_commissions' => 0, 'status' => 'active']
        );

        $patients = Patient::with('protocols.program')
            ->where('pro_user_id', $pro->id)->latest()->get();
        $programs = Program::with('category')->where('is_active', true)->get();

        return Inertia::render('Pro/Patients', compact('patients', 'programs', 'pro'));
    }

    public function protocols()
    {
        $user = auth()->user();
        $pro  = $user->proProfile ?? ProUser::firstOrCreate(
            ['user_id' => $user->id],
            ['commission_rate' => 20, 'total_commissions' => 0, 'status' => 'active']
        );

        $patients  = Patient::with('protocols.program')
            ->where('pro_user_id', $pro->id)->latest()->get();
        $programs  = Program::with('category')->where('is_active', true)->get();
        $protocols = PatientProtocol::with(['patient', 'program'])
            ->whereIn('patient_id', $patients->pluck('id'))
            ->latest()->get();

        return Inertia::render('Pro/Protocols', compact('patients', 'programs', 'protocols', 'pro'));
    }

    public function destroyPatient(Patient $patient)
    {
        $pro = auth()->user()->proProfile;
        if ($patient->pro_user_id === $pro?->id) {
            $patient->delete();
        }
        return back()->with('success', 'Patient supprimé.');
    }
}
