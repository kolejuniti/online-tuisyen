<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'type',
        'total_students',
        'teacher_name',
        'teacher_email',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the teacher coordinator for the school.
     */
    public function teacherCoordinator()
    {
        return $this->hasOne(TeacherCoordinator::class);
    }
}
