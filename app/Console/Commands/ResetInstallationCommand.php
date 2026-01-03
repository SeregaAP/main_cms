<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetInstallationCommand extends Command
{
    protected $signature = 'cms:reset-installation';
    protected $description = 'Сброс установки CMS к начальному состоянию';

    public function handle()
    {
        $this->info('Начинаю сброс установки CMS...');
        
        // 1. Удаляем файл установки
        $installedFile = storage_path('installed');
        if (file_exists($installedFile)) {
            unlink($installedFile);
            $this->info('✓ Файл установки удален');
        } else {
            $this->warn('Файл установки не найден');
        }
        
        // 2. Сбрасываем .env (ТОЛЬКО IS_INSTALL, не трогаем APP_KEY!)
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $env = file_get_contents($envPath);
            
            // Меняем только IS_INSTALL
            if (str_contains($env, 'IS_INSTALL')) {
                $env = preg_replace('/IS_INSTALL=.*/', 'IS_INSTALL=false', $env);
            } else {
                $env .= "\nIS_INSTALL=false";
            }
            
            // НЕ ТРОГАЕМ APP_KEY и настройки БД!
            
            file_put_contents($envPath, $env);
            $this->info('✓ .env обновлен (IS_INSTALL=false)');
        }
        
        // 3. Очищаем кеш БЕЗОПАСНО
        $this->info('Безопасная очистка кеша...');
        
        // Только безопасные команды
        $safeCommands = ['config:clear', 'route:clear', 'view:clear'];
        foreach ($safeCommands as $cmd) {
            try {
                Artisan::call($cmd);
                $this->info("  ✓ {$cmd}");
            } catch (\Exception $e) {
                $this->warn("  ⚠ {$cmd}: " . $e->getMessage());
            }
        }
        
        // 4. Показать следующий шаг
        $this->newLine();
        $this->line('========================================');
        $this->info('✅ Сброс установки завершен!');
        $this->line('');
        $this->line('Важно:');
        $this->line('  • APP_KEY сохранен ✓');
        $this->line('  • Настройки БД сохранены ✓');
        $this->line('  • Права на storage не нарушены ✓');
        $this->line('');
        $this->line('Следующие шаги:');
        $this->line('  1. Перейдите по адресу: /install');
        $this->line('  2. Если нужно - настройте БД в .env');
        $this->line('========================================');
        
        return Command::SUCCESS;
    }
}