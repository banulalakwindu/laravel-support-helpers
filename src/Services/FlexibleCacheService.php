<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Services;

use Banulakwin\SupportHelpers\Contracts\FlexibleCache as FlexibleCacheContract;
use DateTimeInterface;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;

final class FlexibleCacheService implements FlexibleCacheContract
{
    public function __construct(
        private Application $app,
        private CacheManager $cache,
        private ConfigRepository $config,
    ) {}

    /**
     * @param  array<string, mixed>|string  $key
     */
    public function rememberFlexible(array|string $key, DateTimeInterface $ttl, callable $callback): mixed
    {
        if (! $this->shouldUseFlexibleCache()) {
            return $callback();
        }

        $now = now();
        $fresh = $ttl->getTimestamp() - $now->getTimestamp();
        $stale = $fresh + $this->staleExtraSeconds();

        $keyString = is_string($key) ? $key : implode('.', array_keys($key));

        return $this->cache->flexible(
            $keyString,
            [$fresh, $stale],
            $callback,
        );
    }

    public function shouldUseFlexibleCache(): bool
    {
        return (bool) $this->app->environment('production');
    }

    private function staleExtraSeconds(): int
    {
        $value = $this->config->get('support-helpers.cache.flexible_stale_extra_seconds', 300);

        return is_numeric($value) ? (int) $value : 300;
    }
}
