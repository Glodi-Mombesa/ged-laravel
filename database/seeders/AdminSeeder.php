<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Rôle admin (web)
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // Créer l'admin (ou le récupérer s'il existe déjà)
        $admin = User::firstOrCreate(
            ['email' => 'glodi@gmail.com'], // <-- email admin
            [
                'name' => 'Admin',
                'password' => Hash::make('glodi@12345'), // <-- mot de passe
                'email_verified_at' => now(),
            ]
        );

        // Assigner rôle
        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}