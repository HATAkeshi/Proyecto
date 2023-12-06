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
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cursos_id')->unique();

            $table->integer('Nro_de_transaccion');
            $table->string('Nombre');
            $table->decimal('Monto', 10, 2)->default(0.00);
            
            //llave foranea entre cursos y depositos 
            $table->foreign('cursos_id')->references('id')->on('cursos')->onDelete('cascade')
                ->onUpdate('cascade');

            //fecha
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depositos');
    }
};
