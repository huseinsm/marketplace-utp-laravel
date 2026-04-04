<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post') && (!$request->has('name') || !$request->has('email') || !$request->has('password') || !$request->has('role'))) {
            return response()->json(['message' => 'Data name, email, password, dan role wajib diisi!'], 400);
        }
        return $next($request);
    }
}
