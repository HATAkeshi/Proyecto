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
        Schema::create('alquileres', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_de_persona_o_empresa');
            $table->text('Detalle');
            $table->string('Modulos');
            $table->string('Plataforma');
            $table->text('Retraso_de_entrega');
            $table->integer('Nro_de_comprobante')->default(0.00);
            $table->decimal('Ingresos', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquileres');
    }
};
