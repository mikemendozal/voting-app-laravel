<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'title',
        'content',
        'active',
        'created_by',
        'updated_by',
    ];

    public function options()
    {
        return $this->belongsToMany(Option::class)
            ->withTimestamps()
            ->withPivot('id'); // para acceder al ID de la relación
    }

    public function votes(): HasManyThrough
    {
        return $this->hasManyThrough(Vote::class, Option::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
