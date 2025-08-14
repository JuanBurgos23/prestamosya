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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('id_prestamista')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_interes')->constrained('interes')->onDelete('cascade');
            $table->foreignId('id_solicitud')->nullable()->constrained('solicitud_prestamo')->onDelete('cascade');
            //$table->foreignId('id_documento')->constrained('documento')->onDelete('cascade')->nullable();
            $table->decimal('monto_aprobado', 10, 2);
            $table->integer('plazo');
            $table->foreignId('id_tipo_plazo')->constrained('tipos_plazo')->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento');
            $table->string('estado')->default('activo');
            $table->float('monto_total_pagar')->nullable();
            $table->float('interes_total')->nullable();
            $table->float('cuota_estimada')->nullable();
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
