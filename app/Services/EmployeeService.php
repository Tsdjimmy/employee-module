<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function createEmployee(array $data)
    {
        $data['employee_id'] = $this->generateUniqueEmployeeId();
        return Employee::create($data);
    }

    public function updateEmployee(Employee $employee, array $data)
    {
        $employee->update($data);
        return $employee;
    }

    public function deleteEmployee(Employee $employee)
    {
        $employee->delete();
    }

    private function generateUniqueEmployeeId()
    {
        return 'EMP_' . time() . '_' . uniqid();
    }
}
