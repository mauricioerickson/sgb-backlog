<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    /** @use HasFactory<\Database\Factories\ModuleFactory> */
    use HasFactory;

    protected $fillable = ['system_id', 'name'];

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function tasks(): HasMany // Se quiser buscar tasks por modulo diretamente
    {
        return $this->hasMany(Task::class);
    }
}
