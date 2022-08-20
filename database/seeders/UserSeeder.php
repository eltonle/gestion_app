<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'superadmin@gmail.com')->first();
        
        if (is_null($user)) {
            $user = new User();
            $user -> name = 'superadmin';
            $user -> email = 'superadmin@gmail.com';
            $user -> password = Hash::make("password");
            $user -> save();
        }
    }
}
