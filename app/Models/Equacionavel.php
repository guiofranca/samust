<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Equacionavel extends Model
{
    use HasFactory;

    protected $fillable = [
        'equacao_id',
        'nome',
        'grandeza',
        'equacionavel_id',
        'equacionavel_type',
    ];

    public function variavel(): MorphTo
    {
        return $this->morphTo('equacionavel');
    }

    public function equacao(): BelongsTo
    {
        return $this->belongsTo(Equacao::class);
    }
}
