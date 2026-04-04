<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = [
            [
                'id'          => 'monthly',
                'label'       => 'Mensuel',
                'price'       => (float) Setting::get('sub_monthly_price', '29'),
                'period'      => '/ mois',
                'description' => 'Accès illimité à tous les programmes. Sans engagement.',
                'features'    => [
                    'Accès à 37+ protocoles audio',
                    'Nouveaux programmes chaque mois',
                    'Support prioritaire',
                    'Téléchargement offline',
                ],
            ],
            [
                'id'          => 'annual',
                'label'       => 'Annuel',
                'price'       => (float) Setting::get('sub_annual_price', '199'),
                'period'      => '/ an',
                'description' => 'Économisez 40% par rapport au mensuel. Le meilleur choix.',
                'features'    => [
                    'Tout du plan mensuel',
                    'Économisez 40%',
                    'Consultation offerte (1/an)',
                    'Accès anticipé aux nouveautés',
                ],
                'highlight'   => true,
            ],
        ];

        $activeSubscription = auth()->check()
            ? Subscription::where('user_id', auth()->id())
                ->where('status', 'active')
                ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>', now()))
                ->first()
            : null;

        $paymentConfig = [
            'stripe_enabled' => Setting::get('stripe_enabled', '1') === '1',
            'paypal_enabled' => Setting::get('paypal_enabled', '0') === '1',
        ];

        return Inertia::render('Subscribe', compact('plans', 'activeSubscription', 'paymentConfig'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan'           => 'required|in:monthly,annual',
            'payment_method' => 'required|in:stripe,paypal',
        ]);

        $prices = ['monthly' => Setting::get('sub_monthly_price', '29'), 'annual' => Setting::get('sub_annual_price', '199')];
        $price  = (float) $prices[$request->plan];

        $existing = Subscription::where('user_id', auth()->id())->where('status', 'active')->first();
        if ($existing) {
            return back()->with('error', 'Vous avez déjà un abonnement actif.');
        }

        $endsAt = $request->plan === 'monthly'
            ? Carbon::now()->addMonth()
            : Carbon::now()->addYear();

        Subscription::create([
            'user_id'        => auth()->id(),
            'type'           => $request->plan,
            'price'          => $price,
            'status'         => 'active',
            'payment_intent' => 'manual-' . strtoupper(\Str::random(12)),
            'starts_at'      => now(),
            'ends_at'        => $endsAt,
        ]);

        return redirect()->route('pro')->with('success', 'Abonnement activé avec succès ! Bienvenue chez Vitality Inside.');
    }

    public function cancel(Request $request)
    {
        $sub = Subscription::where('user_id', auth()->id())->where('status', 'active')->first();
        if ($sub) {
            $sub->update(['status' => 'cancelled', 'cancelled_at' => now()]);
        }
        return back()->with('success', 'Abonnement annulé.');
    }
}
