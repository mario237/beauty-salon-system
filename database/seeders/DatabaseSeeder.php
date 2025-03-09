<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Department;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::create([
           'name' => 'Super Admin',
           'email' => 'admin@example.com',
           'password' => bcrypt('123456789'),
       ]);

       $this->call([
           SettingSeeder::class
       ]);
    }
}
