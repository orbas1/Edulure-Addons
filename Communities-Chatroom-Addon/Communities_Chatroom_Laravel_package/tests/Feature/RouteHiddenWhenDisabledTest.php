<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Tests\Feature;

use Orchestra\Testbench\TestCase;
use RocketAddons\Communities\Providers\CommunitiesServiceProvider;

class RouteHiddenWhenDisabledTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [CommunitiesServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('communities.enabled', false);
    }

    public function test_routes_guarded_when_disabled(): void
    {
        $route = collect($this->app['router']->getRoutes()->get())
            ->first(fn ($route) => $route->uri() === 'api/communities');

        $this->assertNotNull($route, 'Routes should remain registered for publishing and discovery.');
        $this->assertContains('communities.enabled', $route->middleware());
    }
}
