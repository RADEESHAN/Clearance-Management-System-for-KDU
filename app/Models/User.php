<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = ['id',
        'reg_no', 'user_name', 'email', 'password', 'dep_id',
        'is_student', 'is_management', 'is_super_admin','service_number'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class,'dep_id');
    }

    public function createdDepartments()
    {
        return $this->hasMany(Department::class, 'created_by');
    }

    public function updatedDepartments()
    {
        return $this->hasMany(Department::class, 'updated_by');
    }

    public function createdFaculties()
    {
        return $this->hasMany(Faculty::class, 'created_by');
    }

    public function updatedFaculties()
    {
        return $this->hasMany(Faculty::class, 'updated_by');
    }

    public function studentInfo()
    {
        return $this->hasOne(StudentInfo::class, 'user_id');
    }

    public function createdApplications()
    {
        return $this->hasMany(Application::class, 'created_by');
    }

    public function updatedApplications()
    {
        return $this->hasMany(Application::class, 'updated_by');
    }

}