# Agent guide: `banulakwin/laravel-support-helpers`

Small Laravel helpers for **public disk image URLs** and **production-only flexible cache**.

## Install

- Path or VCS repository in the host app; `composer require banulakwin/laravel-support-helpers`.
- Auto-discovery registers `SupportHelpersServiceProvider`.

## Config

- Publish: `php artisan vendor:publish --tag=support-helpers-config` → `config/support-helpers.php`.
- `image.disk`: Filesystem disk for image resolution (default `public`).
- `image.placeholder_base`: Base URL for default placeholder images.
- `image.avatar_placeholder_base`: Base URL for avatar placeholders.
- `cache.flexible_stale_extra_seconds`: Extra seconds for flexible stale TTL (default `300`).

## Usage

- Cache: `CacheData($key, $ttl, $callback)` — uses `Cache::flexible()` in production; runs callback directly in local/testing.
- Images: `StorageImage($path)`, `AssetImage($path)`, `ResolvedPublicImage($path)`, `defaultPlaceholder()`, `normalizePublicRelativePath($path)`.
- Facades: `PublicImage::storageImage($path)`, `FlexibleCache::rememberFlexible(...)`.

## Testing & Quality

```bash
composer test          # PHPUnit
composer pint          # Laravel Pint code style fix
composer pint:check    # Pint check only (no fix)
composer phpstan       # PHPStan level max on src/
composer quality       # All: pint + phpstan + test
```

## CI

GitHub Actions runs tests, Pint, and PHPStan on push/PR (`.github/workflows/tests.yml`).

## Do not

- Commit generated files (`vendor/`, `composer.lock`, `coverage/`).
