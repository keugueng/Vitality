<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class PaymentSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds for payment configuration.
     * This ensures all required payment keys exist in the settings table.
     */
    public function run(): void
    {
        // Stripe Configuration
        $stripeSettings = [
            'stripe_enabled' => '1',
            'stripe_mode' => 'live', // or 'test' for sandbox
            'stripe_account_email' => 'rosati.eric@gmail.com',
            'stripe_account_id' => 'acct_1GP7bDCXXSFREYqg',
            // IMPORTANT: These must be filled with actual Stripe API keys
            'stripe_pk_live' => '', // pk_live_...
            'stripe_sk_live' => '', // sk_live_...
            'stripe_pk_test' => '', // pk_test_...
            'stripe_sk_test' => '', // sk_test_...
            'stripe_webhook_secret' => '',
        ];

        // PayPal Configuration
        $paypalSettings = [
            'paypal_enabled' => '1',
            'paypal_mode' => 'live', // or 'sandbox' for testing
            'paypal_merchant_id' => 'HMPY7JPJC4XNW',
            'paypal_email' => 'contact.insidevitality@gmail.com',
            // IMPORTANT: These must be filled with actual PayPal API credentials
            'paypal_client_id' => '',
            'paypal_client_secret' => '',
            'paypal_client_id_sandbox' => '',
            'paypal_client_secret_sandbox' => '',
        ];

        // Save all settings
        foreach (array_merge($stripeSettings, $paypalSettings) as $key => $value) {
            // Only set if not already exists (preserve existing values)
            if (Setting::get($key) === null) {
                Setting::set($key, $value);
                $this->command->info("Created setting: {$key}");
            } else {
                $this->command->warn("Setting exists (preserved): {$key}");
            }
        }

        $this->command->newLine();
        $this->command->info('Payment settings seeded successfully!');
        $this->command->warn('IMPORTANT: You must fill in the actual API keys in the admin panel:');
        $this->command->warn('  - stripe_pk_live and stripe_sk_live (Stripe dashboard > Developers > API keys)');
        $this->command->warn('  - paypal_client_id and paypal_client_secret (PayPal dashboard > Apps & Credentials)');
    }
}
