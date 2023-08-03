<?php

use App\Models\Ponto;
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
        Schema::create('medicaos', function (Blueprint $table) {
            $table->foreignIdFor(Ponto::class)->constrained();
            $table->timestamp('instante');
            $table->string('grandeza');
            $table->float('valor');
            $table->timestamps();

            $table->unique(['ponto_id', 'grandeza', 'instante']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicaos');
    }
};
