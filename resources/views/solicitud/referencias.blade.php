@extends('layouts.wizard')

@section('title','Solicitud — Referencias')
@php($currentStep = 2)
@section('step') Paso 2 de 4 @endsection
@section('heading') Referencias del solicitante @endsection
@section('subheading') Agrega al menos dos referencias personales o laborales. @endsection

@section('content')
<div class="mb-4">
  <div class="text-xs text-slate-500 dark:text-slate-400">
    Solicitud: <span class="font-mono">{{ $solicitudId }}</span>
  </div>
</div>

<form id="f" class="grid gap-5">
  <input type="hidden" name="solicitud_id" value="{{ $solicitudId }}"/>

  <div id="rows" class="grid gap-4"></div>

  <div class="flex flex-wrap gap-3">
    <button type="button" id="btn-add"
      class="inline-flex items-center rounded-lg border border-slate-300 dark:border-slate-700 px-4 py-2
             hover:bg-slate-50 dark:hover:bg-slate-900">
      + Agregar referencia
    </button>

    <div class="ms-auto flex gap-2">
      <a href="{{ route('solicitud.datos') }}"
         class="inline-flex items-center rounded-lg px-4 py-2 border border-transparent
                bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700">
        Anterior
      </a>
      <button type="submit"
        class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-white
               hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2
               focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Continuar
      </button>
    </div>
  </div>
</form>

<template id="tpl-row">
  <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start group">
    <div class="md:col-span-3">
      <label class="block text-sm font-medium mb-1">Nombre</label>
      <input name="nombre" required placeholder="Juan Gómez"
        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
               focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
    <div class="md:col-span-3">
      <label class="block text-sm font-medium mb-1">Relación</label>
      <input name="relacion" required placeholder="Amigo / Jefe / Colega"
        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
               focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
    <div class="md:col-span-3">
      <label class="block text-sm font-medium mb-1">Teléfono</label>
      <input name="telefono" required placeholder="3000000000"
        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
               focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
    <div class="md:col-span-2">
      <label class="block text-sm font-medium mb-1">Email</label>
      <input type="email" name="email" placeholder="correo@ejemplo.com"
        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
               focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
    <div class="md:col-span-1 flex md:justify-end">
      <button type="button" class="mt-6 inline-flex items-center justify-center rounded-lg px-3 py-2
                     text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-900 btn-remove"
              title="Eliminar">
        ✕
      </button>
    </div>
  </div>
</template>

<script>
const rows = document.getElementById('rows');
const tpl  = document.getElementById('tpl-row');
const add  = document.getElementById('btn-add');
const form = document.getElementById('f');
const out  = document.getElementById('out');

function addRow(prefill = {}) {
  const node = tpl.content.firstElementChild.cloneNode(true);
  Object.entries(prefill).forEach(([k,v])=>{
    const el = node.querySelector(`[name="${k}"]`);
    if (el) el.value = v ?? '';
  });
  node.querySelector('.btn-remove').addEventListener('click', () => {
    node.remove();
    ensureMinimum();
  });
  rows.appendChild(node);
}

// Asegura mínimo 2 referencias visibles
function ensureMinimum() {
  if (rows.children.length === 0) {
    addRow(); addRow();
  } else if (rows.children.length === 1) {
    addRow();
  }
}

add.addEventListener('click', () => addRow());
ensureMinimum();

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  // Armar payload
  const solicitud_id = form.querySelector('[name="solicitud_id"]').value;
  const referencias = Array.from(rows.children).map(row => {
    const get = n => row.querySelector(`[name="${n}"]`)?.value?.trim() || '';
    return {
      nombre: get('nombre'),
      relacion: get('relacion'),
      telefono: get('telefono'),
      email: get('email'),
    };
  }).filter(r => r.nombre && r.relacion && r.telefono);

  if (referencias.length < 2) {
    alert('Agrega al menos 2 referencias válidas.');
    return;
  }

  try {
    const r = await fetch(`/api/solicitudes/${encodeURIComponent(solicitud_id)}/referencias`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ solicitud_id, referencias })
    });

    const j = await r.json();
    if (out) out.textContent = JSON.stringify(j, null, 2);

    if (r.ok && j.ok) {
      window.location.href = `/solicitud/${encodeURIComponent(solicitud_id)}/soportes`;
    } else {
      alert(j.message || 'No se pudieron guardar las referencias.');
    }
  } catch (err) {
    if (out) out.textContent = err?.message || String(err);
    alert('Error de red.');
  }
});
</script>
@endsection
