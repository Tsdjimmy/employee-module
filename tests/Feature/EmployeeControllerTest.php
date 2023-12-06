<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use App\Constants\Message;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_be_created_via_api()
    {
        $employeeName = 'Unique Employee Name1';
        $department = Department::factory()->create(['name' => 'ITSS']);

        $response = $this->postJson('/api/employees', [
            'name' => $employeeName,
            'department_id' => $department->id,
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => "Employee Created Successfully."]);
    }

    public function test_employee_can_be_updated_via_api()
    {
        $employee_id = 'EMP_' . time() . '_' . uniqid();
        $department = Department::factory()->create(['name' => 'Marketing']);
        $employee = Employee::factory()->create(['name' => 'Jane Smith', 'department_id' => $department->id, 'employee_id' => $employee_id]);
        $response = $this->putJson("/api/employees/{$employee->id}", [
            'name' => 'Updated Name',
            'department_id' => $department->id,
        ]);


        $response->assertStatus(200)
            ->assertJson(['message' => 'Updated Successfully.']);
    }

    public function test_employee_can_be_deleted_via_api()
    {
        $employee_id = 'EMP_' . time() . '_' . uniqid();
        $department = Department::factory()->create(['name' => 'Marketing']);
        $employee = Employee::factory()->create(['name' => 'Jane Smith', 'department_id' => $department->id, 'employee_id' => $employee_id]);

        $response = $this->delete("/api/employees/{$employee->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }

    public function test_employee_can_be_assigned_to_department()
    {
        $department = Department::factory()->create(['name' => 'Example Department']);
        $employee_id = 'EMP_' . time() . '_' . uniqid();

        $employee = Employee::factory()->create(['name' => 'Jane Smith', 'department_id' => $department->id, 'employee_id' => $employee_id]);

        $response = $this->putJson("/api/employees/{$employee->id}/department/{$department->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Employee successfully attached to the department']);
    }

    public function test_delete_department_with_attached_employees()
    {
        $department = Department::factory()->create();
        $employee_id = 'EMP_' . time() . '_' . uniqid();
        $employee = Employee::factory()->create(['name' => 'Jane Smith', 'department_id' => $department->id, 'employee_id' => $employee_id]);

        $response = $this->delete("/api/departments/{$department->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => Message::DELETED_SUCCESSFULLY]);
    }

    public function test_update_employee_with_invalid_department()
    {
        $department = Department::factory()->create();
        $employee_id = 'EMP_' . time() . '_' . uniqid();

        $employee = Employee::factory()->create(['name' => 'Jane Smith', 'department_id' => $department->id, 'employee_id' => $employee_id]);

        $response = $this->putJson("/api/employees/{$employee->id}", [
            'name' => 'Updated Name',
            'department_id' => 999, // Non-existing department ID
        ]);

        $response->assertStatus(422) // Assuming 422 for validation error
            ->assertJsonValidationErrors(['department_id']);
    }
}
