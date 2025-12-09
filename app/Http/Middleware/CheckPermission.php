<?php
// app/Http/Middleware/CheckPermission.php
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

        foreach ($permissions as $permission) {
            $parts = explode('.', $permission);
            $resource = $parts[0];
            $action = $parts[1] ?? null;

            if (auth()->user()->hasPermission($resource, $action)) {
                return $next($request);
            }
        }

        abort(403, 'Доступ запрещен. Недостаточно прав.');
    }
}
