@extends('layouts.wizard')

@section('title','Solicitud — ¡Gracias!')
@php($currentStep = 4)
@section('step') Listo @endsection
@section('heading') ¡Solicitud enviada! @endsection
@section('subheading') Hemos recibido tu solicitud y la estamos revisando. @endsection

@section('content')
@php($sid = ($solicitudId ?? request()->route('solicitud') ?? null))

@if (empty($sid))
  <div class="p-4 rounded-lg bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-300">
    ⚠️ No se encontró el identificador de la solicitud.
  </div>
@else
  <div class="grid gap-6">
    <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 p-6">
      <div class="flex items-start gap-4">
        <div class="h-10 w-10 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M2.25 12a9.75 9.75 0 1119.5 0 9.75 9.75 0 01-19.5 0zm14.03-2.78a.75.75 0 10-1.06-1.06l-5.47 5.47-2.22-2.22a.75.75 0 10-1.06 1.06l2.75 2.75c.3.3.79.3 1.06 0l6-6z" clip-rule="evenodd"/>
          </svg>
        </div>
        <div>
          <h3 class="text-lg font-semibold">¡Listo! Tu solicitud fue enviada correctamente.</h3>
          <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            Guarda este código para seguimiento:
          </p>
          <p class="mt-2 font-mono text-sm break-all">{{ $sid }}</p>
        </div>
      </div>
    </div>

    <div class="flex flex-wrap gap-3">
      <a href="{{ route('solicitud.datos') }}"
         class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-white hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Crear otra solicitud
      </a>
      <a href="{{ url('/') }}"
         class="inline-flex items-center rounded-lg border border-slate-300 dark:border-slate-700 px-5 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-900">
        Volver al inicio
      </a>
    </div>

    <pre id="out" class="hidden whitespace-pre-wrap rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 p-4 text-xs"></pre>
  </div>
@endif
@endsection
