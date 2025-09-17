<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $q = Solicitud::query();

        // filtros simples opcionales
        if ($s = $request->get('s')) {
            $q->where(function ($qq) use ($s) {
                $qq->where('nombre', 'like', "%{$s}%")
                   ->orWhere('documento', 'like', "%{$s}%")
                   ->orWhere('email', 'like', "%{$s}%");
            });
        }
        if ($estado = $request->get('estado')) {
            $q->where('estado', $estado);
        }

        $solicitudes = $q->latest()->paginate(15)->withQueryString();

        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    public function show(Solicitud $solicitud)
    {
        // eager load relaciones si las tienes
        $solicitud->load(['referencias', 'soportes', 'firmas']);

        return view('admin.solicitudes.show', compact('solicitud'));
    }
}
