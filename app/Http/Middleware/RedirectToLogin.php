<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToLogin
{
     
    public function handle($request, Closure $next)
{
    /*if ($request->is('public')) {
        return redirect()->route('login');
    }*/

    return $next($request);
}

}
