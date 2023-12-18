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
        Schema::create('ingresoegresos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('Detalle')->nullable()->default('Reporte');
            $table->string('Nombre')->nullable()->default('-');
            $table->integer('Ingreso');
            $table->integer('Egreso');
            $table->integer('Saldo');
            $table->date('fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresoegresos');
    }
};
