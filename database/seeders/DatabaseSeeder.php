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
        $user = User::factory()->create([
            'nama' => 'Admin',
            'email' => 'admin@cucimotor',
            'password' => bcrypt('admin123')
        ]);
        $user->akses()->create(['akses' => 'Admin Siap Kerja']);


    }
}
