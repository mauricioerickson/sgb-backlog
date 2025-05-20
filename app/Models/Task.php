<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'feature_id', 'system_id', 'module_id', 'title', 'description',
        'estimated_hours', 'task_type', 'priority', 'start_sprint_id',
        'delivery_sprint_id', 'status', 'requester_user_id', 'assignee_user_id',
        'helpdesk_link', 'notes', 'due_date'
    ];

    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function startSprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class, 'start_sprint_id');
    }

    public function deliverySprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class, 'delivery_sprint_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_user_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }
}
