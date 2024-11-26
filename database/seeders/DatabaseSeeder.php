<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
        User::create([
            'name' => 'Aris Maulana',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Nanda',
            'email' => 'nanda@gmail.com',
            'password' => bcrypt('nanda123'),
            'role' => 'karyawan',
        ]);
        User::create([
            'name' => 'Naja',
            'email' => 'naja@gmail.com',
            'password' => bcrypt('naja123'),
            'role' => 'admin',
        ]);
    }
}
