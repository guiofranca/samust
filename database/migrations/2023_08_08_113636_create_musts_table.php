<?php

use App\Models\Equacao;
use App\Models\Ponto;
use App\Models\RelatorioSamust;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('musts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RelatorioSamust::class)->constrained();
            $table->foreignIdFor(Ponto::class)->constrained();
            $table->foreignIdFor(Equacao::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musts');
    }
};
