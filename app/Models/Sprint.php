<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sprint extends Model
{
    /** @use HasFactory<\Database\Factories\SprintFactory> */
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date', 'quarter_id'];

    public function quarter(): BelongsTo
    {
        return $this->belongsTo(Quarter::class);
    }

    public function startTasks(): HasMany // Tarefas que iniciam nesta sprint
    {
        return $this->hasMany(Task::class, 'start_sprint_id');
    }

    public function deliveryTasks(): HasMany // Tarefas com entrega nesta sprint
    {
        return $this->hasMany(Task::class, 'delivery_sprint_id');
    }
}
