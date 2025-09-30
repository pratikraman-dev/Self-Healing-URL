<?php

namespace Bala\SelfHealingUrl;

use Illuminate\Support\ServiceProvider;

class SelfHealingUrlServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/selfhealing.php' => config_path('selfhealing.php'),
        ], 'config');

        // Load fallback route
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/selfhealing.php', 'selfhealing');
    }
}
