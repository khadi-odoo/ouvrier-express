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

            'nom' => 'DIEYE',
            'prenom' => 'Khadija',
            'tel' => '77 500 17 33',
            'adress' => 'DIAXAAY 2',
            'role' => 'admin',
            'email' => 'kadia@gmail.com',
            'login' => 'kadia',
            'password'  => Hash::make('pass@123'),

        ];

        $user = User::create($admin);
        //$admine = $user->admin()->create();
    }
}
