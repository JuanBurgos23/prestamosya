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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_prestamo')->constrained('prestamos');
            $table->decimal('monto', 12, 2);
            $table->date('fecha_pago');
            $table->decimal('interes_pagado', 12, 2);
            $table->decimal('capital_pagado', 12, 2);
            $table->decimal('saldo_restante', 12, 2);
            $table->string('metodo_pago', 50);
            $table->string('comprobante')->nullable();
            $table->text('comentario')->nullable();
            $table->foreignId('id_clienteUser')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
