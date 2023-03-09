<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticateStudent
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('students')->guest()) {
            return redirect()->route('students.login');
        }
        return $next($request);
    }
}
