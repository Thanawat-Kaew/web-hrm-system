<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Employee\EmployeeObject;

class CheckLogin
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
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
        // sd(EmployeeObject::check());
        if (EmployeeObject::check()) {
            return $next($request);
        }
         return redirect('/');

    }
}
