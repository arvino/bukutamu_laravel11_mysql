<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
	public function handle(Request $request, Closure $next, string $role): Response
	{
		if (!auth()->check() || auth()->user()->role !== $role) {
			if ($request->expectsJson()) {
				return response()->json(['error' => 'Unauthorized access'], 403);
			}
			return redirect()->route('home')->with('error', 'Unauthorized access');
		}

		return $next($request);
	}
}