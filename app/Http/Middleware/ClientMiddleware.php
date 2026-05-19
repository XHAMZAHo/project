<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Allow admin and staff to also access client portal (for testing)
        if ($user->isAdmin() || $user->isStaff() || $user->isClient()) {
            return $next($request);
        }

        abort(403, 'Access denied. Client account required.');
    }
}
