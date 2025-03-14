<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $table = 'application_status';

    protected $fillable = [
        'application_id',
        'department_id',
        'status',
        'reason',
        'pdf_path',    // Add this line
        'pdf_reason',  // Add this line
        'created_by',
        'updated_by',
        'receipt_path',
        'service_number',
   
    ];
    protected $casts = [
        'receipt_paths' => 'array',
    ];
    
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    public function user()
    {
        return $this->application->user();
    }

    public function applicationStatus()
    {
        return $this->hasMany(ApplicationStatus::class);
    }
    public function studentInfo()
    {
        return $this->hasOne(StudentInfo::class, 'student_id', 'user_id'); // Adjust column names as per your DB schema
    }
}