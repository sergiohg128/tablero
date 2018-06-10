<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;

class IsAdmin
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ($this->auth->user()->tipo != 'admin') {
            // $this->auth->logout();//si intentan ingresar a un ruta no autorizada el usuario es expultsado del sistema
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->to('actividades');
            }
        }
        return $next($request);
    }
}
