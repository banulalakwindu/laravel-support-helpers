<?php

declare(strict_types=1);

use Banulakwin\SupportHelpers\Contracts\FlexibleCache as FlexibleCacheContract;
use Banulakwin\SupportHelpers\Contracts\PublicImage as PublicImageContract;
use Illuminate\Cache\CacheManager;

if (! function_exists('defaultPlaceholder')) {
    /**
     * Default placeholder image URL using {@see config('app.name')}.
     */
    function defaultPlaceholder(): string
    {
        return app(PublicImageContract::class)->defaultPlaceholder();
    }
}

if (! function_exists('StorageImage')) {
    /**
     * URL for a path on the configured disk, or avatar / null fallbacks.
     */
    function StorageImage(
        ?string $path,
        ?string $placeholder = null,
        bool $isAvatar = false,
        string $name = 'avatar',
    ): ?string {
        return app(PublicImageContract::class)->storageImage($path, $placeholder, $isAvatar, $name);
    }
}

if (! function_exists('normalizePublicRelativePath')) {
    /**
     * Normalize a path for files under {@see public_path()} (handles leading slashes).
     */
    function normalizePublicRelativePath(string $path): string
    {
        return app(PublicImageContract::class)->normalizePublicRelativePath($path);
    }
}

if (! function_exists('ResolvedPublicImage')) {
    /**
     * Public URL for a stored path: configured disk first, then a file under `/public`, then absolute URLs unchanged.
     */
    function ResolvedPublicImage(?string $path): ?string
    {
        return app(PublicImageContract::class)->resolvedPublicImage($path);
    }
}

if (! function_exists('AssetImage')) {
    /**
     * Resolve a public-relative image path, or placeholder / avatar fallback.
     */
    function AssetImage(
        ?string $path,
        ?string $placeholder = null,
        bool $isAvatar = false,
        string $name = 'avatar',
    ): string {
        return app(PublicImageContract::class)->assetImage($path, $placeholder, $isAvatar, $name);
    }
}

if (! function_exists('CacheData')) {
    /**
     * In production, cache with {@see CacheManager::flexible()}.
     * In other environments, runs the callback directly (no cache).
     *
     * @template T
     *
     * @param  array<string, mixed>|string  $key
     * @param  callable(): T  $callback
     * @return T
     */
    function CacheData(array|string $key, DateTimeInterface $ttl, callable $callback): mixed
    {
        return app(FlexibleCacheContract::class)->rememberFlexible($key, $ttl, $callback);
    }
}
