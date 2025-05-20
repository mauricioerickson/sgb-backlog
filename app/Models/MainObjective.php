<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainObjective extends Model
{
    /** @use HasFactory<\Database\Factories\MainObjectiveFactory> */
    use HasFactory;

    protected $fillable = ['quarter_id', 'title', 'description', 'status', 'responsible_user_id', 'notes'];

    public function quarter(): BelongsTo
    {
        return $this->belongsTo(Quarter::class);
    }

    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class, 'objective_id');
    }
}
