<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use App\Models\Soporte;
use App\Models\Referencia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Conteos generales
        $totalSolicitudes = Solicitud::count();
        $solicitudesHoy   = Solicitud::whereDate('created_at', Carbon::today())->count();
        $enviadas         = Solicitud::where('estado', 'enviada')->count();
        $borradores       = Solicitud::where('estado', 'borrador')->count();

        // Relacionados
        $totalSoportes    = Soporte::count();
        $totalReferencias = Referencia::count();

        // Últimas solicitudes
        $ultimas = Solicitud::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSolicitudes',
            'solicitudesHoy',
            'enviadas',
            'borradores',
            'totalSoportes',
            'totalReferencias',
            'ultimas'
        ));
    }
}
