<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventoAuditoria extends Model
{
    use HasFactory;

    protected $table = 'eventos_auditoria';

    protected $fillable = [
        'solicitud_id', 'tipo_evento', 'payload'
    ];

    protected $casts = [
        'payload'    => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}
