<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Solicitud')</title>

  {{-- Inicializa tema antes de pintar --}}
  <script>
    (function () {
      try {
        const stored = localStorage.getItem('theme');
        const prefersDark = matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.toggle('dark', stored ? stored === 'dark' : prefersDark);
      } catch(e){}
    })();
  </script>

  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100 min-h-screen antialiased">

  <div class="container mx-auto px-4 py-10">
    {{-- Header simple --}}
    <div class="flex items-center justify-between mb-6">
      <div class="flex items-center gap-2">
        <span class="inline-block size-2 rounded-full bg-amber-500"></span>
        <span class="font-semibold">Inmobiliaria</span>
      </div>

      <div class="text-sm text-slate-500 dark:text-slate-400">@yield('step')</div>
    </div>

    {{-- Card central --}}
    <div class="max-w-3xl mx-auto">
      <div class="rounded-2xl bg-white dark:bg-slate-900 shadow-xl ring-1 ring-black/5 dark:ring-white/10 p-6 sm:p-8">

        {{-- Stepper superior (1–4) --}}
        @php
          // Espera $currentStep (1..4). Si no llega, asume 1.
          $currentStep = isset($currentStep) ? intval($currentStep) : 1;
          $steps = [
            1 => 'Datos',
            2 => 'Referencias',
            3 => 'Soportes',
            4 => 'Firma',
          ];
        @endphp

        <div class="mb-8">
          <div class="flex items-center justify-center gap-4">
            @foreach($steps as $n => $label)
              <div class="flex items-center gap-4">
                <div class="flex flex-col items-center">
                  <div class="relative">
                    <div class="
                      size-9 rounded-full flex items-center justify-center text-sm font-semibold
                      @if($n <= $currentStep)
                        bg-indigo-600 text-white
                      @else
                        bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300
                      @endif
                    ">{{ $n }}</div>
                  </div>
                  <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">{{ $label }}</div>
                </div>
                @if($n < count($steps))
                  <div class="h-0.5 w-10
                    @if($n < $currentStep) bg-indigo-600 @else bg-slate-200 dark:bg-slate-700 @endif">
                  </div>
                @endif
              </div>
            @endforeach
          </div>
          <div class="text-center mt-3 text-sm text-slate-500 dark:text-slate-400">
            Paso {{ $currentStep }} de {{ count($steps) }}
          </div>
        </div>

        {{-- Heading --}}
        <div class="mb-6">
          <h1 class="text-2xl font-bold tracking-tight">@yield('heading')</h1>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">@yield('subheading')</p>
        </div>

        {{-- Contenido del paso --}}
        <div>
          @yield('content')
        </div>

      </div>

      {{-- Pie: log de respuesta opcional --}}
      <details class="mt-4 text-sm">
        <summary class="cursor-pointer text-slate-500 dark:text-slate-400">Ver respuesta</summary>
        <pre id="out" class="mt-2 rounded-lg bg-slate-900 text-slate-100 p-4 overflow-auto text-xs"></pre>
      </details>
    </div>
  </div>
@yield('scripts')
</body>
</html>
