<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class RelatorioSamust extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function musts() : HasMany
    {
        return $this->hasMany(Must::class);
    }

    public function pontos() : HasManyThrough
    {
        return $this->hasManyThrough(Ponto::class, Must::class, null,'id',null,'ponto_id');
    }
}
