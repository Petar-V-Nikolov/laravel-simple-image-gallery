<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::query()->firstOrCreate(
            ['email' => 'gallery@example.com'],
            [
                'name' => 'Gallery Demo',
                'password' => Hash::make('password'),
            ]
        );
    }
}
