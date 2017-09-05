<?php

namespace App\Http\Middleware;

use Closure;

class Settings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permission = \App\Permission_Profiles::find($request->user()->profile);
        if($permission->settings == 1)
            return $next($request);
        else 
            return redirect('/');
    }
}
