<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feature extends Model
{
    /** @use HasFactory<\Database\Factories\FeatureFactory> */
    use HasFactory;

    protected $fillable = ['objective_id', 'title', 'description', 'status'];

    public function mainObjective(): BelongsTo
    {
        return $this->belongsTo(MainObjective::class, 'objective_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
