<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$profiles): Response
    {
          if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        if ($user->profile === 'T') {
            return $next($request);
        }
        
        if (in_array($user->profile, $profiles) || in_array($user->profile, ['A', 'S'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}


