<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Tests\Feature;

use Orchestra\Testbench\TestCase;
use RocketAddons\Communities\Providers\CommunitiesServiceProvider;

class RouteRegistrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [CommunitiesServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('communities.enabled', true);
    }

    public function test_api_routes_are_registered_with_middleware(): void
    {
        $routes = collect($this->app['router']->getRoutes()->get())
            ->first(fn ($route) => $route->uri() === 'api/communities');

        $this->assertNotNull($routes, 'Communities API routes should be registered when enabled');
        $this->assertContains('communities.enabled', $routes->middleware());
    }

    public function test_can_post_middleware_is_registered(): void
    {
        $this->assertArrayHasKey('communities.can_post', $this->app['router']->getMiddleware());
    }
}
