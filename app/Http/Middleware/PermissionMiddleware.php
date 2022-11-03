<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
        if (\Auth::guest()) {
            return redirect('/login');
        }
        if (! $request->user()->can($permission)) {
          
            \Alert::error('¡Ooops!', 'Permiso denegado');
             return \Redirect::to('/');
        }
        return $next($request);
    }
}
