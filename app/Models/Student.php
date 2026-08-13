<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['roll_number', 'name', 'email', 'class_id'];

    // Relationship to SchoolClass
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // Relationship to Marks
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    // Relationship to Attendances
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}