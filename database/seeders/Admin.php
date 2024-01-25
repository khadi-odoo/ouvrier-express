<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [

            'name' => 'Khadija DIEYE',
            'tel' => '77 500 17 30',
            'adress' => 'DIAXAAY 2',
            'role' => 'admin',
            'email' => 'CC@gmail.com',
            'password'  => Hash::make('pass@123'),

        ];

        $user = User::create($admin);
        //$admine = $user->admin()->create();
    }
}
