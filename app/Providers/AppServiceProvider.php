<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Chunk;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('chunk', function ($expression) {
            return "<?php echo \\App\\Models\\Chunk::render($expression, get_defined_vars()); ?>";
        });
        require_once app_path('helpers.php');

    }
}
