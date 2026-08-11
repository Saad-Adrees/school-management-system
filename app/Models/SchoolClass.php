<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    // Tell Laravel the table name is 'classes' (not 'school_classes')
    protected $table = 'classes'; 
    protected $fillable = ['name'];

    // A Class has many Students
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
public function teachers()
    {
        return $this->hasMany(Teacher::class, 'school_class_id');
    }
}
