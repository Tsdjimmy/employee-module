<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create(['name' => 'John Doe', 'department_id' => 1]);
        Employee::create(['name' => 'Jane Smith', 'department_id' => 2]);
    }
}
