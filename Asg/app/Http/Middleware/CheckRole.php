<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();
        if (!$user || $user->role !== $role) {
            return redirect('/'); // redirect if unauthorized
        }

        return $next($request);
    }
}