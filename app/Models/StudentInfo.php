<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;

    protected $table= 'student_info';

    protected $fillable = [
        'user_id', 'student_reg_no', 'faculty_id', 'tel_no',
    'student_type', 'kdu_id', 'created_by', 'updated_by',
    'bank', 'account_number', 'NIC'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function application()
    {
        return $this->hasOne(Application::class, 'student_id');
    }
}
