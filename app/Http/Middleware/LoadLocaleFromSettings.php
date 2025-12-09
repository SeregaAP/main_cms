<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\App;

class LoadLocaleFromSettings
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
{
    // Пропускаем все маршруты установки
    if ($request->is('install*')) {
        return $next($request);
    }

    // Если CMS не установлена, редиректим на установку
    if (!file_exists(storage_path('installed'))) {
        return redirect('/install');
    }

    // Загружаем настройки локали только после установки
    try {
        $localeSetting = \App\Models\Setting::where('key', 'site_locale')->first();
        
        if ($localeSetting && $localeSetting->value) {
            $locale = $localeSetting->value;
            if (in_array($locale, ['ru', 'en', 'kz'])) {
                app()->setLocale($locale);
            }
        }
    } catch (\Exception $e) {
        // Игнорируем ошибки
    }

    return $next($request);
}
}