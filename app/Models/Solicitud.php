<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Solicitud extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'solicitudes';

    public $incrementing = false;     // porque UUID
    protected $keyType = 'string';    // id es string (uuid)

    protected $fillable = [
        'nombre', 'documento', 'email', 'telefono', 'direccion', 'estado', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function referencias()
    {
        return $this->hasMany(Referencia::class);
    }

    public function soportes()
    {
        return $this->hasMany(Soporte::class);
    }

    public function firmas()
    {
        return $this->hasMany(Firma::class);
    }

    public function eventosAuditoria()
    {
        return $this->hasMany(EventoAuditoria::class);
    }

    // Scopes útiles
    public function scopeEstado($query, string $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeDocumento($query, string $doc)
    {
        return $query->where('documento', $doc);
    }
}
