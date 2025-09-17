<?php

namespace App\Http\Controllers;

class PublicWizardController extends Controller
{
    public function datos()
    {
        return view('solicitud.datos');
    }

    public function referencias(string $solicitud)
    {
        return view('solicitud.referencias', ['solicitudId' => $solicitud]);
    }

    public function soportes(string $solicitud)
    {
        return view('solicitud.soportes', ['solicitudId' => $solicitud]);
    }

    public function firma(string $solicitud)
    {
        return view('solicitud.firma', ['solicitudId' => $solicitud]);
    }

    public function gracias(string $solicitud)
    {
        return view('solicitud.gracias', ['solicitudId' => $solicitud]);
    }

}
