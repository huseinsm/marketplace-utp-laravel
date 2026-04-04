<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post') && (!$request->has('user_id') || !$request->has('name') || !$request->has('address') || !$request->has('phone'))) {
            return response()->json(['message' => 'Data user_id, name, address, dan phone wajib diisi!'], 400);
        }
        return $next($request);
    }
}
