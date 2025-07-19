<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsArtisan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || ! Auth::user()->isArtisan()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté en tant qu\'artisan pour accéder à cette page.');
        }

        return $next($request);
    }
}
