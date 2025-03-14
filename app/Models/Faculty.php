<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $taable = 'departments';

    protected $fillable = [
        'faculty_name', 'parent_faculty', 'created_by', 'updated_by'
    ];

    public function parentFaculty()
    {
        return $this->belongsTo(Faculty::class, 'parent_faculty');
    }

    public function childrenFaculties()
    {
        return $this->hasMany(Faculty::class, 'parent_faculty');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
