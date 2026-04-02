<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();

        $employees = [
            [
                'employee_id' => 'EMP001',
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email' => 'juan.delacruz@nu.edu.ph',
                'phone' => '09171234567',
                'position' => 'Faculty',
                'employment_type' => 'Full-time',
                'ranking' => 'Assistant Professor',
                'status' => 'active',
                'hire_date' => now()->subYears(3),
                'official_time_in' => '08:00',
                'official_time_out' => '17:00',
            ],
            [
                'employee_id' => 'EMP002',
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria.santos@nu.edu.ph',
                'phone' => '09181234567',
                'position' => 'Faculty',
                'employment_type' => 'Full-time',
                'ranking' => 'Associate Professor',
                'status' => 'active',
                'hire_date' => now()->subYears(2),
                'official_time_in' => '08:00',
                'official_time_out' => '17:00',
            ],
            [
                'employee_id' => 'EMP003',
                'first_name' => 'Pedro',
                'last_name' => 'Garcia',
                'email' => 'pedro.garcia@nu.edu.ph',
                'phone' => '09191234567',
                'position' => 'Staff',
                'employment_type' => 'Part-time',
                'ranking' => null,
                'status' => 'active',
                'hire_date' => now()->subYears(1),
                'official_time_in' => '09:00',
                'official_time_out' => '17:00',
            ],
            [
                'employee_id' => 'EMP004',
                'first_name' => 'Ana',
                'last_name' => 'Reyes',
                'email' => 'ana.reyes@nu.edu.ph',
                'phone' => '09201234567',
                'position' => 'Administrative Officer',
                'employment_type' => 'Full-time',
                'ranking' => null,
                'status' => 'active',
                'hire_date' => now()->subMonths(6),
                'official_time_in' => '08:00',
                'official_time_out' => '17:00',
            ],
            [
                'employee_id' => 'EMP005',
                'first_name' => 'Robert',
                'last_name' => 'Cruz',
                'email' => 'robert.cruz@nu.edu.ph',
                'phone' => '09211234567',
                'position' => 'IT Specialist',
                'employment_type' => 'Full-time',
                'ranking' => null,
                'status' => 'active',
                'hire_date' => now()->subMonths(3),
                'official_time_in' => '08:30',
                'official_time_out' => '17:30',
            ],
        ];

        foreach ($employees as $index => $employeeData) {
            $department = $departments->get($index % count($departments));
            Employee::create([
                ...$employeeData,
                'department_id' => $department->id,
            ]);
        }
    }
}
