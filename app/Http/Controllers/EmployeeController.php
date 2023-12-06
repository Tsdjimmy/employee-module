<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Constants\Message;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $employees = Employee::all();
        return response()->json(['message' => Message::FETCHED_SUCCESSFULLY, 'employees' => $employees]);
    }

    public function store(EmployeeRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $employee = $this->employeeService->createEmployee($validatedData);
            return response()->json(['message' => Message::EMPLOYEE_CREATED, 'employee' => $employee], 201);
        } catch (\Exception $e) {
            Log::error(Message::ERROR_CREATING_EMPLOYEE . $e->getMessage());
            return response()->json(['error' => Message::ERROR_CREATING_EMPLOYEE, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        try {
            $validatedData = $request->validated();
            $updatedEmployee = $this->employeeService->updateEmployee($employee, $validatedData);
            
            return response()->json(['message' => Message::UPDATED_SUCCESSFULLY ,'employee' => $updatedEmployee], 200);
        } catch (\Exception $e) {
            Log::error(Message::UPDATED_FAILED . $e->getMessage());
            return response()->json(['error' => Message::UPDATED_FAILED], 500);
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            $this->employeeService->deleteEmployee($employee);
            
            return response()->json(['message' => Message::DELETED_SUCCESSFULLY], 200);
        } catch (\Exception $e) {
            Log::error(Message::DELETE_FAILED . $e->getMessage());
            return response()->json(['error' => Message::DELETE_FAILED], 500);
        }
    }

    public function attachToDepartment(Employee $employee, Department $department)
    {
        try {
            $employee->assignToDepartment($department);

            return response()->json([
                'message' => Message::ATTACHED_SUCCESSFULLY,
                'employee' => $employee,
                'department' => $department,
            ]);
        } catch (\Exception $e) {
            Log::error(Message::ATTACH_FAILED . $e->getMessage());
            return response()->json(['error' => Message::ATTACH_FAILED], 500);
        }
        
    }
}
