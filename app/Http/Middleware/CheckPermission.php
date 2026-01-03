<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Полный доступ
        if ($user->hasPermission('*')) {
            return $next($request);
        }

        foreach ($permissions as $permission) {
            [$resource, $action] = array_pad(
                explode('.', $permission, 2),
                2,
                null
            );

            if ($user->hasPermission($resource, $action)) {
                return $next($request);
            }
        }

        abort(403, 'Доступ запрещен. Недостаточно прав.');
    }
}