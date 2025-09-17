<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Firma extends Model
{
    use HasFactory;

    protected $table = 'firmas';

    protected $fillable = [
        'solicitud_id', 'ruta', 'hash', 'firmante', 'firmado_at'
    ];

    protected $casts = [
        'firmado_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}
