<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckLoginAttempts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * 
     */
    const MAX_ATTEMPTS = 2; // Máximo intentos permitidos
    const BLOCK_TIME = 180; // Tiempo de bloqueo en minutos

    public function handle(Request $request, Closure $next): Response
     {
        if (Auth::check()) {
            return $next($request); // Si el usuario ya está autenticado, continuar
        }

        $ipAddress = $request->ip();
        $attempts = Cache::get('login_attempts_' . $ipAddress, 0);
        $blockTime = Cache::get('login_blocked_' . $ipAddress);

        if ($blockTime) {
            $remainingTime = $blockTime - now()->timestamp;
            if ($remainingTime > 0) {
                return response()->json(['error' => 'Acceso bloqueado temporalmente. Inténtalo más tarde.'], 403);
            }
        }

        if ($attempts >= self::MAX_ATTEMPTS) {
            Cache::put('login_blocked_' . $ipAddress, now()->timestamp + (self::BLOCK_TIME * 60), self::BLOCK_TIME * 60);
            return response()->json(['error' => 'Demasiados intentos fallidos. Acceso bloqueado temporalmente.'], 403);
        }

        return $next($request);
    }
}
