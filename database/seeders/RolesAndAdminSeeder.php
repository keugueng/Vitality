<?php

namespace Database\Seeders;

use App\Models\ProUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['admin', 'user', 'pro'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@vitalityinside.com'],
            [
                'name'     => 'Dr. Éric Rosati',
                'password' => Hash::make('Vitality2025!'),
                'locale'   => 'fr',
            ]
        );
        $admin->assignRole('admin');

        $proUser = User::firstOrCreate(
            ['email' => 'pro@vitalityinside.com'],
            [
                'name'     => 'Sophie Martin',
                'password' => Hash::make('ProVitality2025!'),
                'is_pro'   => true,
                'locale'   => 'fr',
            ]
        );
        $proUser->assignRole('pro');

        ProUser::firstOrCreate(
            ['user_id' => $proUser->id],
            [
                'specialty'         => 'Ostéopathie',
                'commission_rate'   => 20,
                'total_commissions' => 0,
                'status'            => 'active',
            ]
        );

        $demoUser = User::firstOrCreate(
            ['email' => 'demo@vitalityinside.com'],
            [
                'name'     => 'Marie Dubois',
                'password' => Hash::make('Demo2025!'),
                'locale'   => 'fr',
            ]
        );
        $demoUser->assignRole('user');
    }
}
