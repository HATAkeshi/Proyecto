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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->string('Nombre_de_persona');
            $table->string('Porcentaje_de_anticipo');
            $table->string('Nombre_de_persona_pago_total');
            $table->string('Detalle_de_curso');
            $table->integer('Numero_de_comprobante');
            $table->string('metodo_pago');
            $table->decimal('Ingresos', 10, 2)->default(0.00);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
