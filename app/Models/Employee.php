<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function assignToDepartment(Department $department)
    {
        $this->department()->associate($department)->save();
    }

    public function employeeFactory()
    {
        return Employee::factory();
    }
}

