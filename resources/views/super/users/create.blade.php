<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Crear usuario admin</h2>
    </x-slot>

    <div class="p-6">
        @if(session('ok'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700">{{ session('ok') }}</div>
        @endif

        <form method="POST" action="{{ route('super.users.store') }}" class="grid gap-4 max-w-lg">
            @csrf
            <div>
                <label class="label">Nombre</label>
                <input name="name" value="{{ old('name') }}" class="input" required>
                @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input" required>
                @error('email') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="label">Password</label>
                <input type="password" name="password" class="input" required>
                @error('password') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_admin" value="1">
                <span>Dar rol Admin</span>
            </label>

            <div class="flex gap-2">
                <a href="{{ route('super.users.index') }}" class="btn">Cancelar</a>
                <button class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
</x-app-layout>
