<?php

namespace App\Support;

use App\Models\Audit;
use Illuminate\Http\Request;

class Auditor
{
    public static function log(string $event, string $solicitudId, array $changes = [], ?Request $req = null): void
    {
        $req ??= request();

        Audit::create([
            'solicitud_id' => $solicitudId,
            'event'        => $event,
            'changes'      => $changes ?: null,
            'ip'           => $req?->ip(),
            'user_agent'   => $req?->userAgent(),
            // Si más adelante tienes actor autenticado:
            // 'actor_type' => auth()->user() ? get_class(auth()->user()) : null,
            // 'actor_id'   => auth()->id(),
        ]);
    }
}
