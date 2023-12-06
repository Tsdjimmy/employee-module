<?php

namespace App\Http\Controllers;

use App\Constants\Message;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\DepartmentRequest;


class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $departments = Department::all();
        return response()->json(['message' => Message::FETCHED_SUCCESSFULLY, 'departments' => $departments]);
    }

    public function store(DepartmentRequest $request)
    {
        return $this->departmentService->storeDepartment($request);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            $validatedData = $request->validated();
            $result = $this->departmentService->updateDepartment($department, $validatedData);
            
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Department $department)
    {
        try {
            $result = $this->departmentService->deleteDepartment($department);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}