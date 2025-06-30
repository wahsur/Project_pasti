<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'admin',
            'alamat' => 'Tabanan',
            'telepon' => '12345',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'jenis' => 'admin'
        ]);
    }
}
