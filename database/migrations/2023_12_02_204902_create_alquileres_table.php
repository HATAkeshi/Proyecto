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
            $table->text('Detalle')->nullable();
            $table->string('Modulos');
            $table->string('Plataforma');
            $table->text('Retraso_de_entrega')->nullable();
            $table->string('Nro_de_comprobante');
            $table->decimal('Ingresos', 10, 2)->default(0.00);
            $table->timestamps();
            //agragamos la eliminacion suave (soft delete)
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //revertimos la eliminacion sueave
        Schema::table('alquileres', function (Blueprint $table) {
            $table->dropSoftDeletes(); 
        });
    }
};
