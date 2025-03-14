<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'rank_name',
        'person_name',
        'service_number', // Add service number to fillable fields
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
