<?php

namespace App\Http\Middleware;

use App\Enum\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     * @param  string  ...$roles  // Accept variable number of role arguments
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // If no roles specified, deny access
        if (empty($roles)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $hasRequiredRole = $user->roles()->whereIn('name', $roles)->exists();

        if (!$hasRequiredRole) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}