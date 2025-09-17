@extends('layouts.wizard')

@section('title','Solicitud — Datos')
@php($currentStep = 1)
@section('step') Paso 1 de 4 @endsection
@section('heading') Datos del solicitante @endsection
@section('subheading') Completa la información básica para iniciar tu solicitud. @endsection

@section('content')
<form id="f" class="grid gap-5">
  {{-- Fila 1 --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Tipo de persona</label>
      <select name="tipo_persona" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
             focus:ring-indigo-500 focus:border-indigo-500" required>
        <option value="PN">Persona Natural (PN)</option>
        <option value="PJ">Persona Jurídica (PJ)</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Perfil laboral</label>
      <select name="perfil_laboral" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
             focus:ring-indigo-500 focus:border-indigo-500" required>
        <option value="asalariado">Asalariado</option>
        <option value="independiente">Independiente</option>
      </select>
    </div>
  </div>

  {{-- Fila 2 --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Nombre / Razón social</label>
      <input name="nombre" placeholder="Ana Pérez"
             class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
                    focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Documento / NIT</label>
      <input name="documento" placeholder="12345678"
             class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
                    focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
  </div>

  {{-- Fila 3 --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Email</label>
      <input type="email" name="email" placeholder="ana@example.com"
             class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
                    focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Teléfono</label>
      <input name="telefono" placeholder="3001234567"
             class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
                    focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Ingresos mensuales</label>
      <input type="number" name="ingresos_mensuales" placeholder="2000000"
             class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
                    focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">Empresa (si aplica)</label>
    <input name="empresa" placeholder="ACME S.A."
           class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
                  focus:ring-indigo-500 focus:border-indigo-500"/>
  </div>

  {{-- Footer de acción --}}
  <div class="mt-2 flex flex-col sm:flex-row items-start sm:items-center gap-3">
    <button class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-white
                   hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                   focus-visible:outline-indigo-600 transition"
            type="submit">
      Continuar
    </button>

    <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
      Se creará la solicitud en estado <strong>borrador</strong>
    </span>
  </div>
</form>

<script>
const f = document.getElementById('f');
const out = document.getElementById('out');

f.addEventListener('submit', async (e) => {
  e.preventDefault();

  // Recoger datos
  const data = Object.fromEntries(new FormData(f).entries());
  // Para PN sin razón social explícita, manda marcador:
  if (data.tipo_persona === 'PN' && !data.razon_social) data.razon_social = 'NA';

  try {
    const r = await fetch('/api/solicitudes/datos', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(data)
    });

    const j = await r.json();
    if (out) out.textContent = JSON.stringify(j, null, 2);

    // Si OK → ir a Paso 2
    if (j.ok && j.solicitud_id) {
      window.location.href = `/solicitud/${j.solicitud_id}/referencias`;
    }
  } catch (err) {
    if (out) out.textContent = (err?.message || String(err));
  }
});
</script>
@endsection
