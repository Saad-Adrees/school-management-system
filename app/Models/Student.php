<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Notice we changed 'class' to 'class_id' here too!
    protected $fillable = ['roll_number', 'name', 'email', 'class_id'];

    // A Student belongs to a Class
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
    // A Student can have many Marks
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}