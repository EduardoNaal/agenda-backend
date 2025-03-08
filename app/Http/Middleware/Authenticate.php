<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // Verifica si la solicitud no espera un JSON y si no está en una solicitud de API
        if (!$request->expectsJson()) {
            // Puedes comentar o eliminar esta línea ya que no la necesitas para API
            return route('login'); 
        }
        // Retorna null para evitar redirección en solicitudes de API
        return null;
    }
    
    

}
