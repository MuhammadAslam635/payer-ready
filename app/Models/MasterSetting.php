<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'category',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];
}






