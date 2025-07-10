<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeacherCoordinator extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'email',
        'secret_code'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the school that this coordinator belongs to.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Generate a unique secret code.
     */
    public static function generateSecretCode()
    {
        do {
            // Generate random 12-character code with numbers and uppercase letters
            $code = strtoupper(Str::random(4) . rand(1000, 9999) . Str::random(4));
        } while (self::where('secret_code', $code)->exists());

        return $code;
    }

    /**
     * Boot the model and set up event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate secret code when creating a new coordinator
        static::creating(function ($coordinator) {
            if (!$coordinator->secret_code) {
                $coordinator->secret_code = self::generateSecretCode();
            }
        });
    }

    /**
     * Scope to find coordinator by secret code.
     */
    public function scopeBySecretCode($query, $code)
    {
        return $query->where('secret_code', $code);
    }
}
