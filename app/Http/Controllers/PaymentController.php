<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /* ─── Helpers ─── */

    private function cartTotal(): float
    {
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $id => $item) {
            if (str_starts_with($id, 'consult_') || str_starts_with($id, 'sub_')) {
                $total += $item['price'];
            } else {
                $program = Program::find($id);
                if ($program) {
                    $total += $program->price * ($item['quantity'] ?? 1);
                }
            }
        }
        return $total;
    }

    private function stripeKeys(): array
    {
        $mode = Setting::get('stripe_mode', 'test');
        return [
            'mode'       => $mode,
            'public_key' => $mode === 'live' ? Setting::get('stripe_pk_live') : Setting::get('stripe_pk_test'),
            'secret_key' => $mode === 'live' ? Setting::get('stripe_sk_live') : Setting::get('stripe_sk_test'),
        ];
    }

    private function paypalConfig(): array
    {
        $mode = Setting::get('paypal_mode', 'sandbox');
        return [
            'mode'          => $mode,
            'client_id'     => $mode === 'live' ? Setting::get('paypal_client_id')     : Setting::get('paypal_client_id_sandbox'),
            'client_secret' => $mode === 'live' ? Setting::get('paypal_client_secret') : Setting::get('paypal_client_secret_sandbox'),
            'base_url'      => $mode === 'live' ? 'https://api-m.paypal.com'           : 'https://api-m.sandbox.paypal.com',
        ];
    }

    private function getPaypalToken(): ?string
    {
        $cfg = $this->paypalConfig();
        if (!$cfg['client_id'] || !$cfg['client_secret']) return null;

        $response = Http::withBasicAuth($cfg['client_id'], $cfg['client_secret'])
            ->asForm()
            ->post("{$cfg['base_url']}/v1/oauth2/token", ['grant_type' => 'client_credentials']);

        return $response->json('access_token');
    }

    /* ─── Stripe ─── */

    public function stripePublicKey()
    {
        $keys = $this->stripeKeys();
        return response()->json(['public_key' => $keys['public_key']]);
    }

    public function stripeIntent(Request $request)
    {
        // Amount from cart OR from explicit amount parameter (for subscriptions)
        if ($request->has('amount')) {
            $total = (float) $request->amount;
        } else {
            $cart = session('cart', []);
            if (empty($cart)) {
                return response()->json(['error' => 'Panier vide'], 422);
            }
            $total = $this->cartTotal();
        }

        if ($total <= 0) {
            return response()->json(['error' => 'Montant invalide'], 422);
        }

        $keys = $this->stripeKeys();
        if (!$keys['secret_key']) {
            return response()->json(['error' => 'Stripe non configuré. Ajoutez vos clés dans l\'admin.'], 422);
        }

        \Stripe\Stripe::setApiKey($keys['secret_key']);

        $intent = \Stripe\PaymentIntent::create([
            'amount'                    => (int) round($total * 100),
            'currency'                  => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
            'metadata'                  => ['user_id' => auth()->id() ?? 'guest'],
        ]);

        return response()->json([
            'client_secret' => $intent->client_secret,
            'public_key'    => $keys['public_key'],
        ]);
    }

    /* ─── PayPal ─── */

    public function paypalCreateOrder(Request $request)
    {
        // Amount from cart OR from explicit amount parameter (for subscriptions)
        if ($request->has('amount')) {
            $total = (float) $request->amount;
        } else {
            $cart = session('cart', []);
            if (empty($cart)) {
                return response()->json(['error' => 'Panier vide'], 422);
            }
            $total = $this->cartTotal();
        }

        if ($total <= 0) {
            return response()->json(['error' => 'Montant invalide'], 422);
        }

        $token = $this->getPaypalToken();
        if (!$token) {
            return response()->json(['error' => 'PayPal non configuré. Ajoutez vos clés dans l\'admin.'], 422);
        }

        $cfg   = $this->paypalConfig();

        $response = Http::withToken($token)
            ->post("{$cfg['base_url']}/v2/checkout/orders", [
                'intent'         => 'CAPTURE',
                'purchase_units' => [[
                    'amount'      => [
                        'currency_code' => 'EUR',
                        'value'         => number_format($total, 2, '.', ''),
                    ],
                    'description' => 'Vitality Inside — Commande',
                ]],
            ]);

        if (!$response->successful()) {
            \Log::error('PayPal create order error: ' . $response->body());
            return response()->json(['error' => 'Erreur PayPal'], 422);
        }

        return response()->json(['order_id' => $response->json('id')]);
    }

    public function paypalCaptureOrder(Request $request)
    {
        $request->validate(['order_id' => 'required|string']);

        $token = $this->getPaypalToken();
        $cfg   = $this->paypalConfig();

        $response = Http::withToken($token)
            ->post("{$cfg['base_url']}/v2/checkout/orders/{$request->order_id}/capture");

        if (!$response->successful()) {
            \Log::error('PayPal capture error: ' . $response->body());
            return response()->json(['error' => 'Capture PayPal échouée'], 422);
        }

        $status = $response->json('status');
        if ($status !== 'COMPLETED') {
            return response()->json(['error' => "Statut inattendu: {$status}"], 422);
        }

        return response()->json(['status' => 'COMPLETED', 'order_id' => $request->order_id]);
    }
}
