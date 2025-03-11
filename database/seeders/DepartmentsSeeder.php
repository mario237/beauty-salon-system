<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['id' => 1, 'name' => 'Hair', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Nails', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Lashes', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'Microblading', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'Skin Care', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'Waxing or Sweet', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'name' => 'Treatments', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'name' => 'Piercing', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'name' => 'Face Treatments', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'name' => 'Hair Coloring', 'added_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

    }
}
