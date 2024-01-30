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

            'nom' => 'NDOYE',
            'prenom' => 'Libass',
            'tel' => '77 123 56 89',
            'adress' => 'Keur Massar city',
            'role' => 'admin',
            'email' => 'libas@gmail.com',
            //'login' => 'kadia',
            'password'  => Hash::make('pass@123'),

        ];

        $user = User::create($admin);
        //$admine = $user->admin()->create();
    }
}
