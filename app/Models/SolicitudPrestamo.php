<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SolicitudPrestamo extends Model
{
    use HasFactory;
    protected $table = 'solicitud_prestamo';

    protected $fillable = [
        'id',
        'id_cliente',
        'id_prestamista',
        'monto_solicitado',
        'destino_prestamo',
        'tipo_prestamo',
        'id_tipo_plazo',
        'cantidad_plazo',
        'firma_digital',
        'estado',
    ];

    // Relación: una solicitud pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function prestamista()
    {
        return $this->belongsTo(User::class, 'id_prestamista');
    }
    public function detallesDocumentos()
    {
        return $this->hasMany(DetalleDocumento::class, 'id_solicitud_prestamo');
    }
    public function tipoPlazo()
    {
        return $this->belongsTo(TipoPlazo::class, 'id_tipo_plazo');
    }
}
