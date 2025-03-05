<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!$request->user()) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        // Verificar si el usuario tiene el rol de administrador
        if ($request->user()->hasRole('admin')) {
            return $next($request);
        }

        // Si el usuario no es administrador, devolver un error 403
        return response()->json(['message' => 'Acceso denegado: se requiere rol de administrador'], 403);
    }
}
