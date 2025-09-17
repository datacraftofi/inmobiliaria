@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-6 py-10">
  <div class="max-w-5xl w-full bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden flex">

    {{-- Panel Izquierdo --}}
    <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-3">
        Bienvenido 👋
      </h1>
      <p class="text-gray-600 dark:text-gray-400 mb-8">
        Portal de solicitudes y gestión inmobiliaria. Accede con tu cuenta o inicia una nueva solicitud.
      </p>

      <div class="flex flex-col gap-4">
        @auth
          {{-- Si ya inició sesión --}}
          <a href="{{ route('dashboard') }}"
            class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-indigo-600 text-white text-lg font-medium hover:bg-indigo-700 transition">
            📊 Ir al Dashboard
          </a>
        @else
          {{-- Invitado --}}
          <a href="{{ route('login') }}"
            class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-indigo-600 text-white text-lg font-medium hover:bg-indigo-700 transition">
            🔑 Iniciar Sesión
          </a>
        @endauth

        <a href="{{ route('solicitud.datos') }}"
          class="inline-flex items-center justify-center px-6 py-3 rounded-lg border border-indigo-600 text-indigo-600 text-lg font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition">
          📝 Nueva Solicitud
        </a>
      </div>
    </div>

{{-- Panel derecho con imagen de fondo --}}
<div
  class="hidden md:block md:w-1/2 rounded-r-2xl bg-cover bg-center"
  style="background-image: url('{{ asset('img/landing.jpg') }}');"
  role="img"
  aria-label="Imagen de bienes raíces"
>
  {{-- opcional: overlay para contraste del texto si agregas texto aquí
  <div class="bg-black/20 w-full h-full rounded-r-2xl"></div>
  --}}
</div>

  </div>
</div>
@endsection
