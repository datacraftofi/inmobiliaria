@extends('layouts.wizard')

@section('title','Solicitud — Firma')
@php($currentStep = 4)
@section('step') Paso 4 de 4 @endsection
@section('heading') Firma de la solicitud @endsection
@section('subheading') Sube una imagen (PNG/JPG) con tu firma para enviar la solicitud. @endsection

@section('content')
@if (empty($solicitudId))
  <div class="p-4 rounded-lg bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-300">
    ⚠️ No se encontró el identificador de la solicitud.
  </div>
@else
  <div class="mb-4">
    <div class="text-xs text-slate-500 dark:text-slate-400">
      Solicitud: <span class="font-mono">{{ $solicitudId }}</span>
    </div>
  </div>

  <form id="f" class="grid gap-6" enctype="multipart/form-data" data-sid="{{ $solicitudId }}">
    <input type="hidden" name="solicitud_id" value="{{ $solicitudId }}"/>

    <div class="grid gap-2">
      <label class="block text-sm font-medium">Archivo de firma (PNG/JPG)</label>
      <input
        id="firma" name="firma" type="file" accept="image/png,image/jpeg"
        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
               focus:ring-indigo-500 focus:border-indigo-500" required
      />
      <p class="text-xs text-slate-500 dark:text-slate-400">
        Tamaño razonable (ej. &lt; 5MB). Formatos: PNG o JPG.
      </p>

      <div id="preview" class="hidden">
        <div class="text-xs mb-2 text-slate-500 dark:text-slate-400">Vista previa:</div>
        <img id="preview-img" class="max-h-40 rounded border border-slate-200 dark:border-slate-800" />
      </div>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('solicitud.soportes', ['solicitud' => $solicitudId]) }}"
         class="inline-flex items-center rounded-lg px-4 py-2 border border-transparent
                bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700">
        Anterior
      </a>

      <button id="btn-submit" type="submit"
        class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-white
               hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2
               focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Enviar solicitud
      </button>

      <span id="status" class="text-sm text-slate-500"></span>
    </div>
  </form>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form   = document.getElementById('f');
  const input  = document.getElementById('firma');
  const btn    = document.getElementById('btn-submit');
  const status = document.getElementById('status');
  const prev   = document.getElementById('preview');
  const prevImg= document.getElementById('preview-img');

  if (!form) return; // Seguridad

  input.addEventListener('change', () => {
    const file = input.files?.[0];
    if (!file) { prev.classList.add('hidden'); return; }
    prevImg.src = URL.createObjectURL(file);
    prev.classList.remove('hidden');
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault(); // 👈 clave: no deja que el form haga submit normal
    status.textContent = '';
    btn.disabled = true;

    try {
      const solicitud_id = form.querySelector('[name="solicitud_id"]').value;
      const file = input.files?.[0];
      if (!file) throw new Error('Adjunta la imagen de la firma.');

      const fd = new FormData();
      fd.append('solicitud_id', solicitud_id);
      fd.append('firma', file);

      const r = await fetch(`/api/solicitudes/${encodeURIComponent(solicitud_id)}/firma`, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: fd
      });

      const j = await r.json();
      if (r.ok && j.ok) {
        window.location.href = `/solicitud/${solicitud_id}/gracias`;
      } else {
        alert(j.message || 'No se pudo procesar la firma.');
      }
    } catch (err) {
      alert(err.message || 'Error al enviar la firma');
    } finally {
      btn.disabled = false;
    }
  });
});
</script>
@endsection