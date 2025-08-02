<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SolicitudPrestamo extends Model
{
    use HasFactory;
    protected $table = 'solicitud_prestamo';

    protected $fillable = [
        'id_cliente',
        'id_prestamista',
        'monto_solicitado',
        'comentario',
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
}
