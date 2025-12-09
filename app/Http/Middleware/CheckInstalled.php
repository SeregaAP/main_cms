<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckInstalled
{
    public function handle(Request $request, Closure $next)
    {
        // Получаем переменную напрямую из $_ENV/$_SERVER, чтобы сразу видеть новое значение
        $isInstall = ($_ENV['IS_INSTALL'] ?? $_SERVER['IS_INSTALL'] ?? env('IS_INSTALL')) === 'true';
        $path = $request->path();

        // Пока CMS не установлена — все запросы на /install
        if (!$isInstall && $path !== 'install') {
            return redirect('/install');
        }

        // Если уже установлено — запрещаем заходить на /install
        if ($isInstall && $path === 'install') {
            return redirect('/');
        }

        return $next($request);
    }
}
