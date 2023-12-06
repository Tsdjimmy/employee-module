<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use App\Constants\Message;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_department_can_be_created_via_api()
    {
        $departmentName = 'Unique Department Name1';

        $response = $this->postJson('/api/departments', [
            'name' => $departmentName,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "message",
                "department" => [
                    "name",
                    "updated_at",
                    "created_at",
                    "id"
                ]
            ]);
    }


    public function test_department_can_be_updated_via_api()
    {
        $department = Department::factory()->create(['name' => 'HR']);

        $response = $this->putJson("/api/departments/{$department->id}", [
            'name' => 'Updated Department Name1',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'department' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_department_can_be_deleted_via_api()
    {
        $department = Department::factory()->create();

        $response = $this->delete("/api/departments/{$department->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('departments', ['id' => $department->id]);
    }

}
