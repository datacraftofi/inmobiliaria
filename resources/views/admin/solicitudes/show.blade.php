<x-app-layout>
  <x-slot name="header">
    @include('admin.partials.topnav')
  </x-slot>

    <div class="p-6 max-w-7xl mx-auto space-y-6">
        <div class="rounded-xl border p-4 border-slate-200 dark:border-slate-700">
            <div class="text-xs text-slate-500">ID</div>
            <div class="font-mono text-xs">{{ $solicitud->id }}</div>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
                <div>
                    <div class="text-xs text-slate-500">Nombre</div>
                    <div>{{ $solicitud->nombre }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500">Documento</div>
                    <div>{{ $solicitud->documento }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500">Email</div>
                    <div>{{ $solicitud->email }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500">Estado</div>
                    <div><span class="px-2 py-1 rounded bg-slate-200 dark:bg-slate-700 text-xs">{{ $solicitud->estado }}</span></div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border p-4 border-slate-200 dark:border-slate-700">
            <h3 class="font-semibold mb-3">Referencias</h3>
            <ul class="list-disc ms-5 space-y-1">
                @forelse($solicitud->referencias as $r)
                    <li>{{ $r->nombre }} — {{ $r->relacion }} — {{ $r->telefono }} — {{ $r->email }}</li>
                @empty
                    <li class="text-slate-500">Sin referencias</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border p-4 border-slate-200 dark:border-slate-700">
            <h3 class="font-semibold mb-3">Soportes</h3>
            <ul class="space-y-2">
                @forelse($solicitud->soportes as $s)
                    <li class="flex items-center justify-between">
                        <span>{{ $s->tipo ?? 'Soporte' }} — {{ $s->nombre_original }}</span>
                        <a class="text-indigo-600 hover:underline" target="_blank"
                           href="{{ asset('storage/'.$s->ruta) }}">Ver archivo</a>
                    </li>
                @empty
                    <li class="text-slate-500">Sin soportes</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border p-4 border-slate-200 dark:border-slate-700">
            <h3 class="font-semibold mb-3">Firmas</h3>
            <ul class="space-y-2">
                @forelse($solicitud->firmas as $f)
                    <li class="flex items-center justify-between">
                        <span>{{ $f->firmante }} — {{ $f->firmado_at }}</span>
                        <a class="text-indigo-600 hover:underline" target="_blank"
                           href="{{ asset('storage/'.$f->ruta) }}">Ver imagen</a>
                    </li>
                @empty
                    <li class="text-slate-500">Sin firmas</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
