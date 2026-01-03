<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CheckIfInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          // Проверяем наличие файла-индикатора установки
        $installedFile = storage_path('installed');
        
        // Логируем для отладки
        Log::info('CheckIfInstalled middleware:', [
            'path' => $request->path(),
            'installed_file_exists' => File::exists($installedFile),
            'installed_file_path' => $installedFile
        ]);
        
        // Если запрос к установке - пропускаем
        if ($request->is('install*')) {
            return $next($request);
        }
        
        // Если файла нет - редирект на установку
        if (!File::exists($installedFile)) {
            Log::info('Файл установки не найден, редирект на /install');
            return redirect('/install');
        }
        
        // Можно дополнительно проверить содержимое файла
        try {
            $content = File::get($installedFile);
            Log::info('Содержимое файла installed:', ['content' => trim($content)]);
        } catch (\Exception $e) {
            Log::error('Ошибка чтения файла installed:', ['error' => $e->getMessage()]);
        }
        return $next($request);
    }
}
