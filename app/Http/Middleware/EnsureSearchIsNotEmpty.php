<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSearchIsNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $query = $request->get('q');

        if ($query === null || $query === '') {
            return redirect('/');
        }

        return $next($request);
    }
}
