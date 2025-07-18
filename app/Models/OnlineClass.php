<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use App\Models\Student;

class OnlineClass extends Model
{
    use HasFactory;

    protected $table = 'online_class';

    protected $fillable = [
        'name',
        'url',
        'datetime',
        'school',
        'status',
        'addby',
        'subject_id',
    ];

    protected $casts = [
        'school' => 'array',
        'datetime' => 'datetime',
    ];

    /**
     * Get the schools associated with this online class
     */
    public function schools()
    {
        if (!$this->school) {
            return collect([]);
        }
        
        return School::whereIn('id', $this->school)->get();
    }

    /**
     * Get all students from the associated schools
     */
    public function students()
    {
        if (!$this->school) {
            return collect([]);
        }
        
        return Student::whereIn('school_id', $this->school)
            ->where('status', 'active')
            ->with('school')
            ->get();
    }

    /**
     * Check if the class is scheduled for today
     */
    public function isToday()
    {
        return $this->datetime->isToday();
    }

    /**
     * Check if the class is in the past
     */
    public function isPast()
    {
        return $this->datetime->isPast();
    }

    /**
     * Check if the class is upcoming
     */
    public function isUpcoming()
    {
        return $this->datetime->isFuture();
    }

    /**
     * Get the status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->status === 'active' ? 'success' : 'danger';
    }

    /**
     * Get the time badge class based on schedule
     */
    public function getTimeBadgeClassAttribute()
    {
        if ($this->isPast()) {
            return 'secondary';
        } elseif ($this->isToday()) {
            return 'warning';
        } else {
            return 'info';
        }
    }

    /**
     * Get the time badge text
     */
    public function getTimeBadgeTextAttribute()
    {
        if ($this->isPast()) {
            return 'Past';
        } elseif ($this->isToday()) {
            return 'Today';
        } else {
            return 'Upcoming';
        }
    }

    /**
     * Scope for active classes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for upcoming classes
     */
    public function scopeUpcoming($query)
    {
        return $query->where('datetime', '>', now());
    }

    /**
     * Scope for today's classes
     */
    public function scopeToday($query)
    {
        return $query->whereDate('datetime', today());
    }

    /**
     * Scope for past classes
     */
    public function scopePast($query)
    {
        return $query->where('datetime', '<', now());
    }

    /**
     * Get the secure join URL for students
     */
    public function getSecureJoinUrlAttribute()
    {
        return route('online-class.join-page', $this->id);
    }

    /**
     * Get the direct join URL (for authorized access)
     */
    public function getDirectJoinUrlAttribute()
    {
        return route('online-class.join', $this->id);
    }

    /**
     * Get the subject this online class belongs to
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
} 