<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


class InstallController extends Controller
{
    // Шаг 1: Приветствие
    public function welcome()
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }

        return view('install.welcome');
    }

    // Шаг 2: Проверка требований
    public function requirements()
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }

        $requirements = [
            'PHP >= 8.0' => version_compare(PHP_VERSION, '8.0.0', '>='),
            'BCMath Extension' => extension_loaded('bcmath'),
            'Ctype Extension' => extension_loaded('ctype'),
            'JSON Extension' => extension_loaded('json'),
            'Mbstring Extension' => extension_loaded('mbstring'),
            'OpenSSL Extension' => extension_loaded('openssl'),
            'PDO Extension' => extension_loaded('pdo'),
            'Tokenizer Extension' => extension_loaded('tokenizer'),
            'XML Extension' => extension_loaded('xml'),
        ];

        $allPassed = !in_array(false, $requirements, true);

        // Проверка прав на запись
        $writablePaths = [
            'storage' => is_writable(storage_path()),
            'bootstrap/cache' => is_writable(base_path('bootstrap/cache')),
        ];

        $allWritable = !in_array(false, $writablePaths, true);

        return view('install.requirements', compact(
            'requirements', 
            'allPassed', 
            'writablePaths', 
            'allWritable'
        ));
    }

    // Шаг 3: Настройка базы данных
    public function database()
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }

        return view('install.database');
    }

    // Тестирование подключения к БД
    public function testDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'nullable',
        ]);

        try {
            config([
                'database.connections.mysql.host' => $request->db_host,
                'database.connections.mysql.database' => $request->db_name,
                'database.connections.mysql.username' => $request->db_user,
                'database.connections.mysql.password' => $request->db_pass,
            ]);

            DB::purge('mysql');
            DB::reconnect('mysql');
            
            // Тестируем подключение
            DB::connection('mysql')->getPdo();
            
            // Сохраняем настройки в сессии для следующего шага
            session([
                'db_config' => [
                    'host' => $request->db_host,
                    'name' => $request->db_name,
                    'user' => $request->db_user,
                    'pass' => $request->db_pass,
                ]
            ]);

            return response()->json(['success' => true, 'message' => 'Подключение успешно!']);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Ошибка подключения: ' . $e->getMessage()
            ], 422);
        }
    }

    // Шаг 4: Создание администратора
    public function admin()
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }

        // Проверяем, что настройки БД есть в сессии
        if (!session('db_config')) {
            return redirect()->route('install.database');
        }

        return view('install.admin');
    }

    public function setupAdmin(Request $request)
    {
        //\Log::info('=== SETUP ADMIN START ===');
        //\Log::info('SetupAdmin method called');
        
        if (file_exists(storage_path('installed'))) {
            //\Log::info('Installation already completed, redirecting to home');
            return redirect('/');
        }
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email', 
            'password' => 'required|min:6|confirmed',
        ]);
    
        //\Log::info('DB config from session: ' . json_encode(session('db_config')));
        //\Log::info('User data: ' . json_encode($request->only(['name', 'email'])));
    
        try {
            // Применяем настройки БД из сессии
            $dbConfig = session('db_config');
            if (!$dbConfig) {
                //\Log::error('DB config not found in session');
                return back()->with('error', 'Настройки базы данных не найдены. Начните с шага базы данных.');
            }
    
            //\Log::info('Applying DB configuration');
            config([
                'database.connections.mysql.host' => $dbConfig['host'],
                'database.connections.mysql.database' => $dbConfig['name'],
                'database.connections.mysql.username' => $dbConfig['user'],
                'database.connections.mysql.password' => $dbConfig['pass'],
            ]);
    
            DB::purge('mysql');
            DB::reconnect('mysql');
    
            // Проверяем подключение к БД
            //\Log::info('Testing database connection...');
            DB::connection('mysql')->getPdo();
            //\Log::info('Database connection successful');
    
            // Импортируем SQL схему
            $sqlFile = base_path('install/sql/schema.sql');
            if (!file_exists($sqlFile)) {
                //\Log::error('SQL file not found: ' . $sqlFile);
                return back()->with('error', 'SQL файл не найден!');
            }
    
            //\Log::info('Importing SQL schema from: ' . $sqlFile);
            DB::unprepared(file_get_contents($sqlFile));
            //\Log::info('SQL imported successfully');
    
            // Создаем администратора
            //\Log::info('Creating admin user...');
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 1,
                'email_verified_at' => now(),
            ]);
            //\Log::info('Admin user created');
    
            // Обновляем .env
            //\Log::info('Updating .env file...');
            $this->updateEnvFile($dbConfig);
            //\Log::info('Env file updated');
    
            // Генерируем APP_KEY
            //\Log::info('Generating APP_KEY...');
            Artisan::call('key:generate', ['--force' => true]);
            //\Log::info('APP_KEY generated');
    
            // СОЗДАЕМ ФАЙЛ УСТАНОВКИ
            //\Log::info('Creating installed file...');
            $installedFile = storage_path('installed');
            $result = file_put_contents($installedFile, 'CMS installed on: ' . now());
            
            if ($result === false) {
                \Log::error('Failed to write installed file');
                throw new \Exception('Не удалось создать файл установки.');
            }
            
            if (!file_exists($installedFile)) {
                \Log::error('Installed file not found after creation attempt');
                throw new \Exception('Файл установки не был создан.');
            }
            
            //\Log::info('Installed file created successfully: ' . $installedFile);
            //\Log::info('File size: ' . filesize($installedFile) . ' bytes');
    
            // Очищаем сессию
            session()->forget('db_config');
            // Очищаем кеш
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
           /* \Log::info('Cache cleared');
            \Log::info('=== SETUP ADMIN COMPLETED SUCCESSFULLY ===');*/
            return redirect()->route('install.complete');
    
        } catch (\Throwable $e) {
           /* \Log::error('SETUP ADMIN ERROR: ' . $e->getMessage());
            \Log::error('Error in file: ' . $e->getFile() . ' on line: ' . $e->getLine());
            \Log::error('Stack trace: ' . $e->getTraceAsString());*/
            return back()->with('error', 'Ошибка установки: ' . $e->getMessage());
        }
    }

    // Шаг 5: Завершение установки
    public function complete()
    {
        if (!file_exists(storage_path('installed'))) {
            return redirect()->route('install.welcome');
        }

        return view('install.complete');
    }

    // Обновление .env файла
    private function updateEnvFile($dbConfig)
    {
        $envPath = base_path('.env');
        
        if (!file_exists($envPath)) {
            File::copy(base_path('.env.example'), $envPath);
        }
    
        $env = file_get_contents($envPath);
    
        $updates = [
            'APP_NAME' => '"Laravel CMS"',
            'APP_ENV' => 'production',
            'APP_DEBUG' => 'false',
            // НЕ ТРОГАЕМ APP_KEY! Он уже должен быть сгенерирован
            'DB_HOST' => $dbConfig['host'],
            'DB_DATABASE' => $dbConfig['name'],
            'DB_USERNAME' => $dbConfig['user'],
            'DB_PASSWORD' => $dbConfig['pass'] ?: '',
        ];
    
        foreach ($updates as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";
            
            if (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, $replacement, $env);
            } else {
                $env .= PHP_EOL . $replacement;
            }
        }
    
        file_put_contents($envPath, $env);
    }
}