<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// class Application extends Model
// {
//     use HasFactory;

//     protected $table = 'applications';

//     protected $fillable = [
//         'id', 'application_status', 'created_by', 'updated_by'
//     ];

//     public function student()
//     {
//         return $this->belongsTo(StudentInfo::class, 'id');
//     }

//     public function creator()
//     {
//         return $this->belongsTo(User::class, 'created_by');
//     }

//     public function updater()
//     {
//         return $this->belongsTo(User::class, 'updated_by');
//     }

//     public function statuses()
//     {
//         return $this->hasMany(ApplicationStatus::class, 'application_id');
//     }
// }




class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'id', 'user_name','application_status', 'created_by', 'updated_by'
    ];

    public function student()
    {
        return $this->belongsTo(StudentInfo::class, 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function statuses()
    {
        return $this->hasMany(ApplicationStatus::class, 'application_id');
    }
    public function applicationStatus()
    {
        return $this->hasOne(ApplicationStatus::class, 'application_id', 'id');
    }

    // Relationship to retrieve all statuses associated with the application
    public function applicationStatuses()
    {
        return $this->hasMany(ApplicationStatus::class, 'application_id', 'id');
    }

    // Relationship to retrieve the user associated with the application
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function studentInfo()
    {
        return $this->belongsTo(StudentInfo::class, 'student_id');
    }
}

