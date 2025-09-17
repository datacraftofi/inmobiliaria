<x-app-layout>
  <x-slot name="header">
    @include('admin.partials.topnav')
  </x-slot>

    <div class="p-6 max-w-7xl mx-auto">
        <form method="GET" class="mb-4 flex gap-3">
            <input name="s" value="{{ request('s') }}" placeholder="Buscar por nombre, doc, email"
                   class="rounded-lg border-slate-300 dark:border-slate-700"/>
            <select name="estado" class="rounded-lg border-slate-300 dark:border-slate-700">
                <option value="">-- Estado --</option>
                @foreach (['borrador','enviada'] as $e)
                    <option value="{{ $e }}" @selected(request('estado')===$e)>{{ ucfirst($e) }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Filtrar</button>
        </form>

        <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Documento</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Creada</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($solicitudes as $s)
                    <tr class="border-t border-slate-100 dark:border-slate-800">
                        <td class="px-4 py-2 font-mono text-xs">{{ $s->id }}</td>
                        <td class="px-4 py-2">{{ $s->nombre }}</td>
                        <td class="px-4 py-2">{{ $s->documento }}</td>
                        <td class="px-4 py-2">{{ $s->email }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded bg-slate-200 dark:bg-slate-700 text-xs">
                                {{ $s->estado }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $s->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2 text-right">
                            <a class="text-indigo-600 hover:underline"
                               href="{{ route('admin.solicitudes.show', $s) }}">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-6 text-center text-slate-500" colspan="7">Sin resultados</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $solicitudes->links() }}
        </div>
    </div>
</x-app-layout>
