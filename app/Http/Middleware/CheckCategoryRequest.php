<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCategoryRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post') && !$request->has('name')) {
            return response()->json(['message' => 'Nama kategori wajib diisi!'], 400);
        }
        return $next($request);
    }
}
