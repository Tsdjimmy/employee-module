<?php

namespace App\Services;

use App\Constants\Message;
use App\Models\Department;
use App\Http\Requests\DepartmentRequest;

class DepartmentService
{
    public function storeDepartment(DepartmentRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $department = Department::create($validatedData);

            return response()->json(['message' => Message::DEPTARTMENT_CREATED, 'department' => $department], 200);
        } catch (\Exception $e) {
            Log::error(Message::ERROR_CREATING_DEPARTMENT . $e->getMessage());
            return response()->json(['error' => Message::ERROR_CREATING_DEPARTMENT], 500);
        }
    }

    public function updateDepartment(Department $department, array $validatedData)
    {
        try {
            $department->update($validatedData);
            return ['message' => Message::UPDATED_SUCCESSFULLY, 'department' => $department];
        } catch (\Exception $e) {
            Log::error(Message::UPDATED_FAILED . $e->getMessage());
            throw new \Exception(Message::UPDATED_FAILED);
        }
    }

    public function deleteDepartment(Department $department)
    {
        try {
            $department->delete();
            return ['message' => Message::DELETED_SUCCESSFULLY];
        } catch (\Exception $e) {
            Log::error(Message::DELETE_FAILED . $e->getMessage());
            throw new \Exception(Message::DELETE_FAILED);
        }
    }
}
