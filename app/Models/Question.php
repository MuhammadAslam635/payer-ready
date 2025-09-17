<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'description',
        'question_type',
        'options',
        'is_required',
        'sort_order',
        'category',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get all responses to this question
     */
    public function responses(): HasMany
    {
        return $this->hasMany(QuestionResponse::class);
    }
}






