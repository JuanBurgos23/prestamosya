<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('documento')->insert([
            ['nombre' => 'Documento de Identidad (Frente y Reverso)'],
            ['nombre' => 'Comprobante de Ingresos'],
            ['nombre' => 'Factura de Luz'],
            ['nombre' => 'Otros Documentos (Opcional)'],
        ]);
    }
}
