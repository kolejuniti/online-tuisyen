<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'subject_id',
    ];
    
    /**
     * Get the teacher that owns the subject.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the subject that belongs to the teacher.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
