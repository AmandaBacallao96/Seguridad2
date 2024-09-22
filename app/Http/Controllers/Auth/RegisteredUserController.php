<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Añadimos la clase Log para usar el sistema de logs
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
        // Registrar el inicio de la solicitud de registro
        Log::info('Iniciando proceso de registro de usuario', ['request_data' => $request->all()]);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email' // Cambié la validación unique
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

        // Registrar los datos validados
        Log::info('Datos validados correctamente', ['validated_data' => $validatedData]);

        try {
            // Intentamos crear el usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Si el usuario es creado, registramos la operación en el log
            Log::info('Usuario creado correctamente', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            // Si ocurre algún error, lo registramos en el log
            Log::error('Error al crear el usuario', ['error_message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Error al crear el usuario. Por favor, inténtelo de nuevo.']);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('form.create');
    }
}
