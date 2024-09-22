<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar los datos ingresados
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:20',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/u' // No admite números, solo letras y espacios
            ],
            'apellidos' => [
                'required',
                'string',
                'min:2',
                'max:40',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/u' // No admite números, solo letras y espacios
            ],
            'dni' => [
                'required',
                'regex:/^\d{8}[A-Z]$/', // Valida el formato DNI español (8 números seguidos de una letra)
                'unique:users,dni',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
                'min:10', // Longitud mínima
                'regex:/[A-Za-z]/', // Al menos una letra
                'regex:/[0-9]/', // Al menos un número
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Al menos un carácter especial
            ],
        ]);

        // Intentar crear el usuario
        try {
            $user = User::create([
                'name' => $request->name,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Registrar al usuario
            Log::info('Usuario creado correctamente', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            // Registrar error
            Log::error('Error al crear el usuario', ['error_message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Error al crear el usuario. Por favor, inténtelo de nuevo.']);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('form.create');
    }
}
