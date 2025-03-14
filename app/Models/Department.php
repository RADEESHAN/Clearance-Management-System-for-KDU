<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'dep_name','email', 'parent_department', 'created_by', 'updated_by' ,'faculty_id' // Added faculty_id here
    ];

    public function parentDepartment()
    {
        return $this->belongsTo(Department::class, 'parent_department');
    }

    public function childrenDepartments()
    {
        return $this->hasMany(Department::class, 'parent_department');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function applicationStatuses()
    {
        return $this->hasMany(ApplicationStatus::class, 'department_id');
    }

    public function applicationStatus()
    {
        return $this->hasMany(ApplicationStatus::class, 'department_id');
    }

    // Relationship to the faculty
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
    public function ranks()
    {
        return $this->hasMany(Rank::class);
    }
 
}
