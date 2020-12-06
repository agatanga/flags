<?php

namespace Agatanga\Flags;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FlagsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/flags.php', 'flags');

        $this->app->singleton(Factory::class, function (Application $app) {
            $config = $app->make('config')->get('flags');

            return new Factory(
                new Filesystem(),
                $config['ratio'] ?? '',
                $config['class'] ?? ''
            );
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        Blade::directive('flag', function ($expression) {
            return "<?php echo e(flag($expression)); ?>";
        });

        $this->publishes([
            __DIR__ . '/../config/flags.php' => config_path('flags.php'),
        ]);
    }
}
