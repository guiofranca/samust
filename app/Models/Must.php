<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Must extends Model
{
    use HasFactory;

    protected $fillable = [
        'relatorio_samust_id',
        'ponto_id',
        'equacao_id',
    ];

    public function relatorio() : BelongsTo
    {
        return $this->belongsTo(RelatorioSamust::class);
    }

    public function ponto() : BelongsTo
    {
        return $this->belongsTo(Ponto::class);
    }

    public function equacao() : BelongsTo
    {
        return $this->belongsTo(Equacao::class);
    }


}
