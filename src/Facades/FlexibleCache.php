<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Facades;

use Banulakwin\SupportHelpers\Contracts\FlexibleCache as FlexibleCacheContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed rememberFlexible(array<string, mixed>|string $key, \DateTimeInterface $ttl, callable $callback)
 * @method static bool shouldUseFlexibleCache()
 *
 * @see FlexibleCacheContract
 */
final class FlexibleCache extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FlexibleCacheContract::class;
    }
}
