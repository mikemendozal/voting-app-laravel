<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $table = "options";

    protected $fillable = [
        'content',
        'question_id',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class)
            ->withTimestamps();
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
