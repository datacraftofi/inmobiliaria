<?php

namespace App\Http\Controllers;

use App\Http\Requests\DatosClienteRequest;
use App\Http\Requests\ReferenciasRequest;
use App\Http\Requests\SoportesRequest;
use App\Http\Requests\FirmaRequest;
use App\Models\Solicitud;
// use App\Models\Referencia; // (opcional, no se usa directamente)
// use App\Models\Soporte;    // (opcional, no se usa directamente)
use App\Support\Auditor;      // ← AUDITORÍA
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SolicitudPublicController extends Controller
{
    /**
     * Paso 1: Crea una Solicitud (estado = "borrador").
     */
    public function storeDatos(DatosClienteRequest $request)
    {
        $data = $request->validated();

        $solicitud = Solicitud::create([
            'nombre'    => $data['nombre'] ?? ($data['razon_social'] ?? null),
            'documento' => $data['documento'] ?? ($data['nit'] ?? null),
            'email'     => $data['email'] ?? null,
            'telefono'  => $data['telefono'] ?? null,
            'direccion' => $data['direccion'] ?? null,
            'estado'    => 'borrador',
            'meta'      => [
                'tipo_persona'       => $data['tipo_persona'] ?? null,
                'perfil_laboral'     => $data['perfil_laboral'] ?? null,
                'empresa'            => $data['empresa'] ?? null,
                'ingresos_mensuales' => $data['ingresos_mensuales'] ?? null,
            ],
        ]);

        // AUDITORÍA
        Auditor::log('solicitud_creada', $solicitud->id, [
            'tipo_persona'   => $solicitud->meta['tipo_persona'] ?? null,
            'perfil_laboral' => $solicitud->meta['perfil_laboral'] ?? null,
        ]);

        return response()->json([
            'ok' => true,
            'solicitud_id' => $solicitud->id,
            'message' => 'Datos del cliente guardados. Continúa con referencias.',
        ], 201);
    }

    /**
     * Paso 2: Guarda referencias de la solicitud.
     */
    public function storeReferencias(ReferenciasRequest $request, Solicitud $solicitud)
    {
        $data = $request->validated();

        if ($data['solicitud_id'] !== $solicitud->id) {
            return response()->json(['ok' => false, 'message' => 'Solicitud no coincide.'], 422);
        }

        DB::transaction(function () use ($solicitud, $data) {
            $solicitud->referencias()->delete();

            foreach ($data['referencias'] as $r) {
                $solicitud->referencias()->create([
                    'nombre'   => $r['nombre'],
                    'relacion' => $r['relacion'] ?? null,
                    'telefono' => $r['telefono'] ?? null,
                    'email'    => $r['email'] ?? null,
                ]);
            }
        });

        // AUDITORÍA
        Auditor::log('referencias_agregadas', $solicitud->id, [
            'count' => count($data['referencias']),
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Referencias guardadas. Continúa con soportes.',
        ]);
    }

    /**
     * Paso 3: Adjunta soportes (archivos).
     */
    public function storeSoportes(SoportesRequest $request, Solicitud $solicitud)
    {
        $data = $request->validated();

        if (($data['solicitud_id'] ?? null) !== $solicitud->id) {
            return response()->json(['ok' => false, 'message' => 'Solicitud no coincide.'], 422);
        }

        $disk = 'public';
        $basePath = "solicitudes/{$solicitud->id}/soportes";
        $saved = [];

        // 1) supports[] (simple)
        if ($request->hasFile('supports')) {
            foreach ($request->file('supports') as $file) {
                $ruta = $file->store($basePath, $disk);
                $hash = hash_file('sha256', $file->getRealPath());

                $saved[] = $solicitud->soportes()->create([
                    'nombre_original' => $file->getClientOriginalName(),
                    'ruta'            => $ruta,
                    'disk'            => $disk,
                    'mime_type'       => $file->getClientMimeType(),
                    'size'            => $file->getSize(),
                    'hash'            => $hash,
                    'tipo'            => null,
                ]);
            }
        }

        // 2) items[].file + items[].tipo (estructurado)
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!isset($item['file']) || !$item['file'] instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }
                $file = $item['file'];
                $tipo = $item['tipo'] ?? null;

                $ruta = $file->store($basePath, $disk);
                $hash = hash_file('sha256', $file->getRealPath());

                $saved[] = $solicitud->soportes()->create([
                    'nombre_original' => $file->getClientOriginalName(),
                    'ruta'            => $ruta,
                    'disk'            => $disk,
                    'mime_type'       => $file->getClientMimeType(),
                    'size'            => $file->getSize(),
                    'hash'            => $hash,
                    'tipo'            => $tipo,
                ]);
            }
        }

        if (count($saved) === 0) {
            return response()->json([
                'ok' => false,
                'message' => 'No se recibieron archivos de soporte.',
            ], 422);
        }

        // AUDITORÍA
        Auditor::log('soportes_adjuntados', $solicitud->id, [
            'count' => count($saved),
            'files' => collect($saved)->map(fn($s) => [
                'ruta' => $s->ruta,
                'mime' => $s->mime_type,
                'size' => $s->size,
                'hash' => $s->hash,
            ])->all(),
        ]);

        return response()->json([
            'ok' => true,
            'count' => count($saved),
            'message' => 'Soportes cargados. Continúa con la firma.',
        ]);
    }

    /**
     * Paso 4: Adjunta firma (archivo o base64) y marca solicitud como "enviada".
     */
    public function storeFirma(FirmaRequest $request, Solicitud $solicitud)
    {
        $data = $request->validated();

        if (($data['solicitud_id'] ?? null) !== $solicitud->id) {
            return response()->json(['ok' => false, 'message' => 'Solicitud no coincide.'], 422);
        }

        $disk = 'public';
        $basePath = "solicitudes/{$solicitud->id}/firmas";

        $ruta = null;
        $filename = null;

        if ($request->hasFile('firma')) {
            $file = $request->file('firma');
            $ruta = $file->store($basePath, $disk);
            $hash = hash_file('sha256', $file->getRealPath());

            $solicitud->firmas()->create([
                'ruta'       => $ruta,
                'hash'       => $hash,
                'firmante'   => $solicitud->nombre,
                'firmado_at' => now(),
            ]);
        } elseif (!empty($data['firma_base64'])) {
            $bin = base64_decode($data['firma_base64']);
            $filename = $basePath.'/'.Str::uuid().'.png';
            Storage::disk($disk)->put($filename, $bin);
            $fullPath = Storage::disk($disk)->path($filename);
            $hash = hash_file('sha256', $fullPath);

            $solicitud->firmas()->create([
                'ruta'       => $filename,
                'hash'       => $hash,
                'firmante'   => $solicitud->nombre,
                'firmado_at' => now(),
            ]);
        }

        $solicitud->update(['estado' => 'enviada']);

        // AUDITORÍAS
        Auditor::log('firma_registrada', $solicitud->id, [
            'ruta' => $ruta ?? $filename ?? null,
        ]);

        Auditor::log('solicitud_enviada', $solicitud->id, [
            'estado' => $solicitud->estado,
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Firma cargada. Solicitud enviada.',
            'solicitud_id' => $solicitud->id,
            'estado' => $solicitud->estado,
        ]);
    }

    public function auditorias(Solicitud $solicitud)
    {
        return response()->json([
            'ok' => true,
            'auditorias' => $solicitud->auditorias()->latest()->get(),
        ]);
    }



}
