<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    // Verificar si el usuario está bloqueado
    if ($user && $user->blocked_until && $user->blocked_until > now()) {
        return back()->withErrors(['email' => 'Tu cuenta está bloqueada temporalmente.']);
    }

    // Intentar autenticar
    if (Auth::attempt($request->only('email', 'password'))) {
        // Restablecer los intentos fallidos
        $user->failed_login_attempts = 0;
        $user->blocked_until = null;
        $user->save();

        return redirect()->route('form.create');
    } else {
        // Incrementar intentos fallidos
        $user->failed_login_attempts++;

        // Bloquear la cuenta si alcanza 2 intentos fallidos
        if ($user->failed_login_attempts >= 2) {
            $user->blocked_until = now()->addMinutes(180);
        }

        $user->save();

        return back()->withErrors(['email' => 'Las credenciales son incorrectas.']);
    }
}

    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
