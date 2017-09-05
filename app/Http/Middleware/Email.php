<?php

namespace App\Http\Middleware;

use Closure;

class Email
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
        if($permission->email == 1)
            return $next($request);
        else 
            return redirect('/');
    }
}
