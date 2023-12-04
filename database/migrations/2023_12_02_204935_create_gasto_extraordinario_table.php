<?php

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
        Schema::create('gasto_extraordinario', function (Blueprint $table) {
            $table->id();
            $table->text('Motivo_resumido_de_salida_de_dinero');
            $table->string('Nombre_a_quien_se_entreg el_dinero');
            $table->string('Quien_aprobo_la_ entrega_de_dinero');
            $table->integer('Nro_de_comprobante');
            $table->decimal('Monto', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gasto_extraordinario');
    }
};
