<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JSONResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // Set Accept application/json header
        $request->headers->set('Accept', 'application/json');

        return $next($request);

        // Force JSON  format on all responses
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
}
