<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin Account
        User::updateOrCreate(
            ['nim' => 'admin'],
            [
                'name' => 'Administrator',
                'jurusan' => 'Staff',
                'prodi' => 'Akademik',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin'
            ]
        );

        // Create User Account
        User::updateOrCreate(
            ['nim' => '123456'],
            [
                'name' => 'Mahasiswa Contoh',
                'jurusan' => 'Teknik',
                'prodi' => 'Informatika',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'user'
            ]
        );

        $this->call([
            AspirasiEventSeeder::class,
            AgendaSeeder::class,
        ]);
    }
}
