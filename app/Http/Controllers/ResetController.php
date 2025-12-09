<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    public function resetInstallation()
    {
        // Удаляем файл установки
        if (file_exists(storage_path('installed'))) {
            unlink(storage_path('installed'));
        }

        // Сбрасываем .env
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $env = file_get_contents($envPath);
            $env = preg_replace('/IS_INSTALL=.*/', 'IS_INSTALL=false', $env);
            file_put_contents($envPath, $env);
        }

        // Очищаем кеш
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        return redirect('/install')->with('success', 'Установка сброшена! Можете начать заново.');
    }
}
