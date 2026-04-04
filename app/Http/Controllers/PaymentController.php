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
        $keys = [
            'mode'       => $mode,
            'public_key' => $mode === 'live' ? Setting::get('stripe_pk_live') : Setting::get('stripe_pk_test'),
            'secret_key' => $mode === 'live' ? Setting::get('stripe_sk_live') : Setting::get('stripe_sk_test'),
        ];
        
        // Log which keys are missing for debugging
        if (!$keys['public_key']) {
            \Log::error('Stripe: Missing public key (stripe_pk_' . $mode . ')');
        }
        if (!$keys['secret_key']) {
            \Log::error('Stripe: Missing secret key (stripe_sk_' . $mode . ')');
        }
        
        return $keys;
    }

    private function paypalConfig(): array
    {
        $mode = Setting::get('paypal_mode', 'sandbox');
        $clientId = $mode === 'live' ? Setting::get('paypal_client_id') : Setting::get('paypal_client_id_sandbox');
        $clientSecret = $mode === 'live' ? Setting::get('paypal_client_secret') : Setting::get('paypal_client_secret_sandbox');
        
        // Log which keys are missing for debugging
        if (!$clientId) {
            \Log::error('PayPal: Missing client_id (paypal_client_id' . ($mode === 'sandbox' ? '_sandbox' : '') . ')');
        }
        if (!$clientSecret) {
            \Log::error('PayPal: Missing client_secret (paypal_client_secret' . ($mode === 'sandbox' ? '_sandbox' : '') . ')');
        }
        
        return [
            'mode'          => $mode,
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
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

    /* ─── Debug / Diagnostics ─── */

    /**
     * Return the current payment configuration status.
     * Useful for debugging which keys are missing.
     */
    public function paymentConfigStatus()
    {
        $stripeMode = Setting::get('stripe_mode', 'test');
        $paypalMode = Setting::get('paypal_mode', 'sandbox');

        $stripeKeys = [
            'stripe_enabled' => Setting::get('stripe_enabled', '0'),
            'stripe_mode' => $stripeMode,
            'stripe_account_email' => Setting::get('stripe_account_email'),
            'stripe_account_id' => Setting::get('stripe_account_id'),
            'stripe_pk_live_exists' => (bool) Setting::get('stripe_pk_live'),
            'stripe_sk_live_exists' => (bool) Setting::get('stripe_sk_live'),
            'stripe_pk_test_exists' => (bool) Setting::get('stripe_pk_test'),
            'stripe_sk_test_exists' => (bool) Setting::get('stripe_sk_test'),
        ];

        $paypalKeys = [
            'paypal_enabled' => Setting::get('paypal_enabled', '0'),
            'paypal_mode' => $paypalMode,
            'paypal_merchant_id' => Setting::get('paypal_merchant_id'),
            'paypal_email' => Setting::get('paypal_email'),
            'paypal_client_id_exists' => (bool) Setting::get('paypal_client_id'),
            'paypal_client_secret_exists' => (bool) Setting::get('paypal_client_secret'),
            'paypal_client_id_sandbox_exists' => (bool) Setting::get('paypal_client_id_sandbox'),
            'paypal_client_secret_sandbox_exists' => (bool) Setting::get('paypal_client_secret_sandbox'),
        ];

        // Determine what's missing
        $stripeReady = $stripeKeys['stripe_enabled'] === '1' && (
            ($stripeMode === 'live' && $stripeKeys['stripe_pk_live_exists'] && $stripeKeys['stripe_sk_live_exists']) ||
            ($stripeMode === 'test' && $stripeKeys['stripe_pk_test_exists'] && $stripeKeys['stripe_sk_test_exists'])
        );

        $paypalReady = $paypalKeys['paypal_enabled'] === '1' && (
            ($paypalMode === 'live' && $paypalKeys['paypal_client_id_exists'] && $paypalKeys['paypal_client_secret_exists']) ||
            ($paypalMode === 'sandbox' && $paypalKeys['paypal_client_id_sandbox_exists'] && $paypalKeys['paypal_client_secret_sandbox_exists'])
        );

        return response()->json([
            'stripe' => [
                'ready' => $stripeReady,
                'config' => $stripeKeys,
                'missing' => $this->getMissingStripeKeys($stripeMode, $stripeKeys),
            ],
            'paypal' => [
                'ready' => $paypalReady,
                'config' => $paypalKeys,
                'missing' => $this->getMissingPaypalKeys($paypalMode, $paypalKeys),
            ],
            'message' => 'Check the "missing" arrays to see which API keys need to be configured in the admin panel.',
        ]);
    }

    private function getMissingStripeKeys(string $mode, array $keys): array
    {
        $missing = [];
        if ($keys['stripe_enabled'] !== '1') {
            $missing[] = 'stripe_enabled is not active';
        }
        if ($mode === 'live') {
            if (!$keys['stripe_pk_live_exists']) $missing[] = 'stripe_pk_live (Publishable Key Live)';
            if (!$keys['stripe_sk_live_exists']) $missing[] = 'stripe_sk_live (Secret Key Live)';
        } else {
            if (!$keys['stripe_pk_test_exists']) $missing[] = 'stripe_pk_test (Publishable Key Test)';
            if (!$keys['stripe_sk_test_exists']) $missing[] = 'stripe_sk_test (Secret Key Test)';
        }
        return $missing;
    }

    private function getMissingPaypalKeys(string $mode, array $keys): array
    {
        $missing = [];
        if ($keys['paypal_enabled'] !== '1') {
            $missing[] = 'paypal_enabled is not active';
        }
        if ($mode === 'live') {
            if (!$keys['paypal_client_id_exists']) $missing[] = 'paypal_client_id (Client ID Live)';
            if (!$keys['paypal_client_secret_exists']) $missing[] = 'paypal_client_secret (Client Secret Live)';
        } else {
            if (!$keys['paypal_client_id_sandbox_exists']) $missing[] = 'paypal_client_id_sandbox (Client ID Sandbox)';
            if (!$keys['paypal_client_secret_sandbox_exists']) $missing[] = 'paypal_client_secret_sandbox (Client Secret Sandbox)';
        }
        return $missing;
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
