<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Referencia extends Model
{
    use HasFactory;

    protected $table = 'referencias';

    protected $fillable = [
        'solicitud_id', 'nombre', 'relacion', 'telefono', 'email'
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}
