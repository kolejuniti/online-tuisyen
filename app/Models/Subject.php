<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'image',
    ];
    
    /**
     * Get the teachers that belong to the subject.
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_subjects')
                    ->withTimestamps();
    }
}
