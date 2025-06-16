<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStudent extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'ic';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ic',
        'name',
        'email',
        'no_matric',
        'status',
        'school_id'
    ];
} 