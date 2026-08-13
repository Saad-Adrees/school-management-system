<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'attendance_date',
        'status',
    ];

    /**
     * Get the student that owns the attendance record.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}