<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        // Búsqueda simple
        $q = User::query();
        if ($s = $request->get('s')) {
            $q->where(function ($qq) use ($s) {
                $qq->where('name', 'like', "%{$s}%")
                   ->orWhere('email', 'like', "%{$s}%");
            });
        }

        // Solo admins / superadmins para esta vista (si quieres)
        $q->orderByDesc('is_superadmin')->orderByDesc('is_admin')->orderBy('name');

        $users = $q->paginate(15)->withQueryString();

        return view('super.users.index', compact('users'));
    }

    public function create()
    {
        return view('super.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255', Rule::unique('users','email')],
            'password' => ['required','string','min:8'],
            // marcar admin por checkbox opcional
            'is_admin' => ['nullable','boolean'],
        ]);

        $user = new User();
        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->is_admin = (bool)($data['is_admin'] ?? false);
        // NOTA: no toques is_superadmin aquí, solo lo manejas tú manualmente
        $user->save();

        return redirect()->route('super.users.index')
            ->with('ok','Usuario admin creado');
    }
}
