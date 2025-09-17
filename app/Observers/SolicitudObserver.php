<?php

namespace App\Observers;

use App\Models\Solicitud;
use App\Models\EventoAuditoria;

class SolicitudObserver
{
    public function created(Solicitud $solicitud): void
    {
        EventoAuditoria::create([
            'solicitud_id' => $solicitud->id,
            'tipo_evento'  => 'CREACION',
            'payload'      => ['snapshot' => $solicitud->only(['nombre','documento','email','estado'])],
        ]);
    }

    public function updated(Solicitud $solicitud): void
    {
        $changes = $solicitud->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            EventoAuditoria::create([
                'solicitud_id' => $solicitud->id,
                'tipo_evento'  => 'ACTUALIZACION',
                'payload'      => ['changes' => $changes],
            ]);
        }
    }

    public function deleting(Solicitud $solicitud): void
    {
        EventoAuditoria::create([
            'solicitud_id' => $solicitud->id,
            'tipo_evento'  => 'ELIMINACION',
            'payload'      => ['snapshot' => $solicitud->only(['nombre','documento','email','estado'])],
        ]);
    }
}
