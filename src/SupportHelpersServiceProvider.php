<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers;

use Banulakwin\SupportHelpers\Contracts\FlexibleCache as FlexibleCacheContract;
use Banulakwin\SupportHelpers\Contracts\PublicImage as PublicImageContract;
use Banulakwin\SupportHelpers\Services\FlexibleCacheService;
use Banulakwin\SupportHelpers\Services\PublicImageService;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

final class SupportHelpersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/support-helpers.php', 'support-helpers');

        $this->app->singleton(PublicImageService::class);
        $this->app->singleton(PublicImageContract::class, static fn (Container $app) => $app->make(PublicImageService::class));

        $this->app->singleton(FlexibleCacheService::class);
        $this->app->singleton(FlexibleCacheContract::class, static fn (Container $app) => $app->make(FlexibleCacheService::class));
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/support-helpers.php' => config_path('support-helpers.php'),
        ], 'support-helpers-config');
    }
}
