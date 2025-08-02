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
        Schema::create('solicitud_prestamo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente'); // cliente que solicita
            $table->unsignedBigInteger('id_prestamista'); // su prestamista asignado
            $table->float('monto_solicitado');
            $table->text('comentario')->nullable(); // opcional
            $table->string('estado')->default('pendiente');

            $table->foreign('id_cliente')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_prestamista')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_prestamo');
    }
};
