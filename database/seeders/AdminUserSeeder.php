<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Haal credentials uit .env of gebruik deze fallback (verander wachtwoord direct!)
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', 'ChangeMe123!');

        // Maak admin alleen aan als niet bestaat
        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Beheerder',
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );
    }
}
