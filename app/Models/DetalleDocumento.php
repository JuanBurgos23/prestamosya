<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleDocumento extends Model
{
    protected $table = 'detalle_documentos';
    protected $fillable = [
        'id_documento',
        'id_solicitud_prestamo',
        'ruta'
    ];
    public function solicitud()
    {
        return $this->belongsTo(SolicitudPrestamo::class, 'id_solicitud');
    }
}
