<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Equacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'formula',
    ];

    public function equacionaveis() : HasMany {
        return $this->hasMany(Equacionavel::class);
    }
}
