<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'Admin',
                'fullname' => '',
                'no_telp' => '',
            ],
            [
                'name' => 'Petugas',
                'email' => 'petugas@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'Petugas',
                'fullname' => '',
                'no_telp' => '',
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('123123'),
                'role' => 'User',
                'fullname' => 'user',
                'no_telp' => '087824318334',
            ],
        ];
        User::insert($data);
    }
}
