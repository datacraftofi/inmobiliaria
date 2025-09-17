<x-app-layout>
  <x-slot name="header">
    @include('admin.partials.topnav')
  </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-6">
            {{-- KPIs --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Solicitudes totales</div>
                    <div class="mt-1 text-3xl font-semibold">{{ $totalSolicitudes }}</div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Hoy</div>
                    <div class="mt-1 text-3xl font-semibold">{{ $solicitudesHoy }}</div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Enviadas</div>
                    <div class="mt-1 text-3xl font-semibold">{{ $enviadas }}</div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Borradores</div>
                    <div class="mt-1 text-3xl font-semibold">{{ $borradores }}</div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Soportes</div>
                    <div class="mt-1 text-3xl font-semibold">{{ $totalSoportes }}</div>
                </div>
                <div class="rounded-2xl p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="text-sm text-slate-500">Referencias</div>
                    <div class="mt-1 text-3xl font-semibold">{{ $totalReferencias }}</div>
                </div>
            </div>

            {{-- Últimas solicitudes --}}
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold">Últimas solicitudes</h3>
                </div>
                <div class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse ($ultimas as $s)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div class="min-w-0">
                                <div class="text-sm font-medium truncate">{{ $s->nombre ?? '—' }}</div>
                                <div class="text-xs text-slate-500 font-mono truncate">{{ $s->id }}</div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-xs px-2 py-1 rounded-full
                                    {{ $s->estado === 'enviada' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' }}">
                                    {{ $s->estado }}
                                </span>
                                <span class="text-xs text-slate-500">{{ $s->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-6 text-sm text-slate-500">Aún no hay solicitudes.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
