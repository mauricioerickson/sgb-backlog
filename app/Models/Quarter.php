<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quarter extends Model
{
    /** @use HasFactory<\Database\Factories\QuarterFactory> */
    use HasFactory;
    
    protected $fillable = ['name', 'start_date', 'end_date'];

    public function mainObjectives(): HasMany
    {
        return $this->hasMany(MainObjective::class);
    }

    public function sprints(): HasMany
    {
        return $this->hasMany(Sprint::class);
    }
}
