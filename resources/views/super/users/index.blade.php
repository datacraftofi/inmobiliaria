<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Superadmin — Usuarios</h2>
            <a href="{{ route('super.users.create') }}" class="btn btn-primary">+ Nuevo</a>
        </div>
    </x-slot>

    <div class="p-6">
        <form class="mb-4">
            <input type="text" name="s" value="{{ request('s') }}" placeholder="Buscar…" class="input">
            <button class="btn">Buscar</button>
        </form>

        <div class="rounded-2xl border p-4 bg-white dark:bg-slate-900">
            @forelse($users as $u)
                <div class="flex items-center justify-between py-2 border-b last:border-0">
                    <div>
                        <div class="font-medium">{{ $u->name }}</div>
                        <div class="text-sm text-slate-500">{{ $u->email }}</div>
                    </div>
                    <div class="text-xs">
                        @if($u->is_superadmin) <span class="px-2 py-1 rounded bg-purple-100 text-purple-700">Superadmin</span> @endif
                        @if($u->is_admin) <span class="px-2 py-1 rounded bg-indigo-100 text-indigo-700">Admin</span> @endif
                    </div>
                </div>
            @empty
                <div>No hay usuarios.</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-app-layout>
