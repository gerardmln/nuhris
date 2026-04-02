<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'College of Engineering',
            'College of Business',
            'College of Education',
            'College of Arts & Sciences',
            'College of Computing',
            'College of Allied Health',
            'Administration',
            'Human Resources',
        ];

        foreach ($departments as $name) {
            Department::firstOrCreate(['name' => $name]);
        }
    }
}
