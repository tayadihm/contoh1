<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // akun admin
        DB::table('users')->insertOrIgnore([
            // [
            //     'nik' => '250404',
            //     'name' => 'Admin',
            //     'email' => 'admin@gmail.com',
            //     'phone' => '085335249308',
            //     'password' => Hash::make('admin'),
            //     'roles' => 'ADMIN',
            // ],
            // [
            //     'nik' => '90001122',
            //     'name' => 'Admin2',
            //     'email' => 'admin2@gmail.com',
            //     'phone' => '085335249309',
            //     'password' => Hash::make('admin'),
            //     'roles' => 'ADMIN',
            // ]
            [
                'nik'       => '111111',
                'name'      => 'Super Admin',
                'email'     => 'superadmin@gmail.com',
                'phone'     => '087770822121',
                'password'  => Hash::make('superadmin'),
                'roles'     => 'SUPER ADMIN'
            ]
        ]);
    }
}
