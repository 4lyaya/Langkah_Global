<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Custom Blade directives
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d M Y, H:i'); ?>";
        });

        Blade::directive('relativeTime', function ($expression) {
            return "<?php echo ($expression)->diffForHumans(); ?>";
        });

        Blade::directive('numberFormat', function ($expression) {
            return "<?php echo number_format($expression); ?>";
        });

        // Register policies
        \App\Models\Post::observe(\App\Observers\PostObserver::class);
        \App\Models\Comment::observe(\App\Observers\CommentObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
    }
}