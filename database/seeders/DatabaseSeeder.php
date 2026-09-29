<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::insert([
            [
            'name' => 'Admin',
            'email' => 'admin@openperpus.local',
            'password'=>bcrypt('0987654321'),
            'phone_num'=>'080989999',
            'role'=>'Admin'
            ],
            [
            'name' => 'Peminjam 1',
            'email' => 'peminjam1@email.test',
            'password'=>bcrypt('1234567890'),
            'phone_num'=>'088888888888',
            'role'=>'Peminjam'
            ]
        ]);
    }
}
