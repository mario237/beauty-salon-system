<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            // Nails
            ['name' => 'Pedicure foot', 'price' => 120, 'duration' => 30, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pedicure hand', 'price' => 100, 'duration' => 30, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paraffin wax', 'price' => 80, 'duration' => 30, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manicure', 'price' => 35, 'duration' => 30, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Installing nails', 'price' => 150, 'duration' => 45, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Callus off', 'price' => 150, 'duration' => 40, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'New set hard gel', 'price' => 350, 'duration' => 60, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Refill hard gel', 'price' => 200, 'duration' => 45, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Leg hard gel', 'price' => 250, 'duration' => 45, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gel polish', 'price' => 200, 'duration' => 30, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Leg gel polish', 'price' => 150, 'duration' => 30, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Treatment', 'price' => 300, 'duration' => 45, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Removing hard gel', 'price' => 100, 'duration' => 30, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Removing leg hard gel', 'price' => 100, 'duration' => 30, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fixing for one finger', 'price' => 25, 'duration' => 15, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Design', 'price' => 50, 'duration' => 20, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fake nails', 'price' => 180, 'duration' => 40, 'department_id' => 2, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            // Skin Care
            ['name' => '5 Level Facial', 'price' => 250, 'duration' => 45, 'department_id' => 5, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '7 Level Facial', 'price' => 300, 'duration' => 60, 'department_id' => 5, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '10 Level Facial', 'price' => 400, 'duration' => 75, 'department_id' => 5, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hydra Facial', 'price' => 650, 'duration' => 60, 'department_id' => 5, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hydra Facial +', 'price' => 850, 'duration' => 75, 'department_id' => 5, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            // Waxing or Sweet
            ['name' => 'Full Body Wax', 'price' => 450, 'duration' => 60, 'department_id' => 6, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Full Legs Wax', 'price' => 150, 'duration' => 30, 'department_id' => 6, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Half Legs Wax', 'price' => 100, 'duration' => 20, 'department_id' => 6, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            // Treatments
            ['name' => 'Caviar Treatments', 'price' => 3000, 'duration' => 120, 'department_id' => 7, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cold Hair Treatments', 'price' => 500, 'duration' => 60, 'department_id' => 7, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Deep Conditioner', 'price' => 100, 'duration' => 45, 'department_id' => 7, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hair Session with Natural Oils & Shea Butter', 'price' => 450, 'duration' => 90, 'department_id' => 7, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            // Lashes
            ['name' => 'Lashes one piece', 'price' => 100, 'duration' => 30, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lashes one by one', 'price' => 260, 'duration' => 45, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lashes classic', 'price' => 450, 'duration' => 60, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hybrid', 'price' => 500, 'duration' => 60, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Volume', 'price' => 550, 'duration' => 60, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mega Volume', 'price' => 600, 'duration' => 75, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Refill', 'price' => 300, 'duration' => 45, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lash Lifting', 'price' => 500, 'duration' => 45, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lashes half eye', 'price' => 80, 'duration' => 30, 'department_id' => 3, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            // Piercing
            ['name' => 'Nose', 'price' => 100, 'duration' => 30, 'department_id' => 8, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ear', 'price' => 150, 'duration' => 30, 'department_id' => 8, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            // Face
            ['name' => 'Eyebrow and Mustache', 'price' => 45, 'duration' => 30, 'department_id' => 9, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Face Threading', 'price' => 70, 'duration' => 30, 'department_id' => 9, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Face Wax', 'price' => 80, 'duration' => 30, 'department_id' => 9, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Face Shaving', 'price' => 90, 'duration' => 30, 'department_id' => 9, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Face Dermaplaning', 'price' => 100, 'duration' => 30, 'department_id' => 9, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Eyebrows Color', 'price' => 35, 'duration' => 30, 'department_id' => 9, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Brightening & Freshness Mask', 'price' => 100, 'duration' => 30, 'department_id' => 9, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            // Hair Coloring
            ['name' => 'Single Color Process', 'price' => 750, 'duration' => 90, 'department_id' => 10, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'One Light Color with Lightening', 'price' => 1200, 'duration' => 120, 'department_id' => 10, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Root Retouch', 'price' => 450, 'duration' => 60, 'department_id' => 10, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Partial Highlights', 'price' => 500, 'duration' => 90, 'department_id' => 10, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Full Highlights', 'price' => 1200, 'duration' => 120, 'department_id' => 10, 'added_by' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
