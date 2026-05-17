<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Contracts;

use DateTimeInterface;
use Illuminate\Cache\CacheManager;

interface FlexibleCache
{
    /**
     * When {@see self::shouldUseFlexibleCache()} is true, uses {@see CacheManager::flexible()}.
     * Otherwise runs the callback directly.
     *
     * @template T
     *
     * @param  array<string, mixed>|string  $key
     * @param  callable(): T  $callback
     * @return T
     */
    public function rememberFlexible(array|string $key, DateTimeInterface $ttl, callable $callback): mixed;

    /**
     * Override in a custom binding or subclass to change when flexible caching runs (e.g. staging).
     */
    public function shouldUseFlexibleCache(): bool;
}
