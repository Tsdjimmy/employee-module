<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static $departmentId = 1;

    public function definition()
    {
        $num = 1;
        return [
            'name' => $this->faker->word,
            'department_id' => self::$departmentId++, 
        ];
    }
}
