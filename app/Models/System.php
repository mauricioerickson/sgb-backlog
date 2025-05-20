<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class System extends Model
{
    /** @use HasFactory<\Database\Factories\SystemFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function tasks(): HasMany // Se quiser buscar tasks por sistema diretamente
    {
        return $this->hasMany(Task::class);
    }
}
