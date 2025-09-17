@extends('layouts.wizard')

@section('title','Solicitud — Soportes')
@php($currentStep = 3)
@section('step') Paso 3 de 4 @endsection
@section('heading') Adjunta tus soportes @endsection
@section('subheading') Carga los documentos requeridos (PDF o imágenes). @endsection

@section('content')
<div class="mb-4">
  <div class="text-xs text-slate-500 dark:text-slate-400">
    Solicitud: <span class="font-mono">{{ $solicitudId }}</span>
  </div>
</div>

<form id="f" class="grid gap-6" enctype="multipart/form-data">
  <input type="hidden" name="solicitud_id" value="{{ $solicitudId }}"/>

  <div id="rows" class="grid gap-4"></div>

  <div class="flex flex-wrap gap-3">
    <button type="button" id="btn-add"
      class="inline-flex items-center rounded-lg border border-slate-300 dark:border-slate-700 px-4 py-2
             hover:bg-slate-50 dark:hover:bg-slate-900">
      + Agregar soporte
    </button>

    <div class="ms-auto flex gap-2">
      <a href="{{ route('solicitud.referencias',['solicitud'=>$solicitudId]) }}"
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
  <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start group border rounded-lg p-3 bg-white dark:bg-slate-950 shadow-sm">
    <div class="md:col-span-4">
      <label class="block text-sm font-medium mb-1">Tipo de soporte</label>
      <input name="tipo" required placeholder="Ej: Cédula, Certificado"
        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950
               focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>
    <div class="md:col-span-6">
      <label class="block text-sm font-medium mb-1">Archivo</label>
      <input type="file" name="file" required
        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4
               file:rounded-md file:border-0 file:text-sm file:font-semibold
               file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
    </div>
    <div class="md:col-span-2 flex md:justify-end">
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

function addRow() {
  const node = tpl.content.firstElementChild.cloneNode(true);
  node.querySelector('.btn-remove').addEventListener('click', () => {
    node.remove();
    ensureMinimum();
  });
  rows.appendChild(node);
}

function ensureMinimum() {
  if (rows.children.length === 0) addRow();
}

add.addEventListener('click', () => addRow());
ensureMinimum();

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  const solicitud_id = form.querySelector('[name="solicitud_id"]').value;
  const data = new FormData(form);

  // Renombrar los inputs dinámicamente como items[index][campo]
  Array.from(rows.children).forEach((row, i) => {
    const tipo = row.querySelector('[name="tipo"]');
    const file = row.querySelector('[name="file"]');
    if (tipo?.value) data.append(`items[${i}][tipo]`, tipo.value);
    if (file?.files[0]) data.append(`items[${i}][file]`, file.files[0]);
  });

  try {
    const r = await fetch(`/api/solicitudes/${encodeURIComponent(solicitud_id)}/soportes`, {
      method: 'POST',
      headers: { 'Accept': 'application/json' },
      body: data
    });

    const j = await r.json();
    if (out) out.textContent = JSON.stringify(j, null, 2);

    if (r.ok && j.ok) {
      window.location.href = `/solicitud/${encodeURIComponent(solicitud_id)}/firma`;
    } else {
      alert(j.message || 'No se pudieron guardar los soportes.');
    }
  } catch (err) {
    if (out) out.textContent = err?.message || String(err);
    alert('Error de red.');
  }
});
</script>
@endsection
