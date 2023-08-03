<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Ponto extends Model
{
    use HasFactory;

    public function medicoes(): HasMany
    {
        return $this->hasMany(Medicao::class);
    }

    public function equacionaveis() : MorphMany {
        return $this->morphMany(Equacionavel::class, 'equacionavel');
    }
}
