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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('ci');
            $table->date('fecha_nacimiento');
            $table->string('nacionalidad');
            $table->string('telefono');
            $table->string('direccion');
            $table->string('email')->nullable();
            $table->string('ocupacion');
            $table->decimal('egresos_mensuales', 10, 2);
            $table->string('referencia_nombre');
            $table->string('referencia_ci');
            $table->string('referencia_telefono');
            $table->string('lugar_trabajo');
            $table->string('estado_civil');
            $table->string('genero');
            $table->string('foto')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
