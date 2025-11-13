<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeUserAdminSeeder extends Seeder
{
    public function run()
    {
        $email = 'wdfdsa@cx.com';

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'name' => 'Henk',
                'email' => $email,
                'password' => Hash::make('secret123'),
                'is_admin' => true,
            ]);
        } else {
            $user->is_admin = true;
            $user->save();
        }
    }
}
