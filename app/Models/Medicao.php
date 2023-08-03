<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicao extends Model
{
    use HasFactory;

    protected $fillable = [
        'ponto_id',
        'instante',
        'grandeza',
    ];
}
