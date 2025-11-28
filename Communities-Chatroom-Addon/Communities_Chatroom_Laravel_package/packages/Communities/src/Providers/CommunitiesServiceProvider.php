<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use RocketAddons\Communities\Http\Middleware\EnsureCommunitiesEnabled;
use RocketAddons\Communities\Http\Middleware\EnsureCommunityMembership;
use RocketAddons\Communities\Http\Middleware\EnsureCommunityCanPost;
use RocketAddons\Communities\Http\Middleware\EnsureFeatureEnabled;
use RocketAddons\Communities\Policies\ChannelPolicy;
use RocketAddons\Communities\Policies\CommunityPolicy;
use RocketAddons\Communities\Policies\DMThreadPolicy;
use RocketAddons\Communities\Policies\MessagePolicy;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Models\DMThread;
use RocketAddons\Communities\Models\ChannelMessage;
use RocketAddons\Communities\Services\FileScanner\ClamAvFileScanner;
use RocketAddons\Communities\Services\FileScanner\FileScannerInterface;
use RocketAddons\Communities\Services\FileScanner\HttpFileScanner;
use RocketAddons\Communities\Services\FileScanner\NullFileScanner;

class CommunitiesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/communities.php', 'communities');

        $this->app->bind(FileScannerInterface::class, function () {
            return match (config('communities.file_scanner.driver')) {
                'clamav' => new ClamAvFileScanner(),
                'http' => new HttpFileScanner(),
                default => new NullFileScanner(),
            };
        });
    }

    public function boot(): void
    {
        /**
         * Register in config/app.php providers array when auto-discovery is disabled:
         * RocketAddons\Communities\Providers\CommunitiesServiceProvider::class
         */

        $this->registerPublishes();
        $this->registerPolicies();
        $this->registerMiddleware();
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        if (!config('communities.enabled')) {
            return;
        }

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'communities');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'communities');
        $this->registerViewComposers();
    }

    protected function registerRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../../routes/communities_api.php');

        Route::middleware('web')
            ->group(__DIR__ . '/../../routes/communities_web.php');
    }

    protected function registerPolicies(): void
    {
        Gate::policy(Community::class, CommunityPolicy::class);
        Gate::policy(Channel::class, ChannelPolicy::class);
        Gate::policy(DMThread::class, DMThreadPolicy::class);
        Gate::policy(ChannelMessage::class, MessagePolicy::class);
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('communities.enabled', EnsureCommunitiesEnabled::class);
        $router->aliasMiddleware('communities.feature', EnsureFeatureEnabled::class);
        $router->aliasMiddleware('communities.membership', EnsureCommunityMembership::class);
        $router->aliasMiddleware('communities.can_post', EnsureCommunityCanPost::class);
    }

    protected function registerViewComposers(): void
    {
        View::composer('layouts.*', static function ($view): void {
            if (!config('communities.enabled')) {
                return;
            }

            $menu = $view->getData()['communitiesMenu'] ?? [];
            $menu[] = [
                'title' => __('communities::communities.title'),
                'url' => route('communities.index'),
            ];

            if (config('communities.features.dm')) {
                $menu[] = [
                    'title' => __('communities::communities.direct_messages'),
                    'url' => route('dm.index'),
                ];
            }

            $view->with('communitiesMenu', $menu);
        });
    }

    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/communities.php' => config_path('communities.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/communities'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/communities'),
            __DIR__ . '/../../public/vendor/communities' => public_path('vendor/communities'),
        ], 'views');
    }
}
