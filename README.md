# Laravel Support Helpers (`banulakwin/laravel-support-helpers`)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/banulakwin/laravel-support-helpers.svg?style=flat-square)](https://packagist.org/packages/banulakwin/laravel-support-helpers)
[![Tests](https://github.com/banulakwin/laravel-support-helpers/actions/workflows/tests.yml/badge.svg)](https://github.com/banulakwin/laravel-support-helpers/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/banulakwin/laravel-support-helpers.svg?style=flat-square)](https://packagist.org/packages/banulakwin/laravel-support-helpers)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

**Image URL resolution** (storage disk + public assets + placeholders) and a **production-only `Cache::flexible()`** wrapper—delivered as **contracts**, **services**, **facades**, and **global helpers** (helpers delegate to the container, so behaviour stays consistent).

---

## Requirements

- PHP `^8.4` (uses `mb_trim` / `mb_ltrim`)
- Laravel `illuminate/*` `^11.0|^12.0|^13.0` (cache, filesystem, support)

---

## Installation

Auto-discovery registers `Banulakwin\SupportHelpers\SupportHelpersServiceProvider`.

```bash
composer require banulakwin/laravel-support-helpers
```

Optional publish (customize placeholders, disk, stale window):

```bash
php artisan vendor:publish --tag=support-helpers-config
```

| Config key | Purpose |
|------------|---------|
| `image.disk` | Filesystem disk for `storageImage` / `resolvedPublicImage`. Env: `SUPPORT_HELPERS_IMAGE_DISK`. |
| `image.placeholder_base` | Prefix for `defaultPlaceholder` / `assetImage` when no image. Env: `SUPPORT_HELPERS_PLACEHOLDER_BASE`. |
| `image.avatar_placeholder_base` | Prefix when avatar file missing. Env: `SUPPORT_HELPERS_AVATAR_PLACEHOLDER_BASE`. |
| `cache.flexible_stale_extra_seconds` | Seconds after the fresh window for the flexible stale bound. Env: `SUPPORT_HELPERS_CACHE_STALE_EXTRA` (default `300`). |

**Facades** (optional): `PublicImage`, `FlexibleCache` (see `composer.json` `extra.laravel.aliases`).

---

## Architecture (recommended for apps)

| Layer | Role |
|-------|------|
| **`Banulakwin\SupportHelpers\Contracts\PublicImage`** | Swap or mock image behaviour in tests / custom apps. |
| **`Banulakwin\SupportHelpers\Services\PublicImageService`** | Default implementation (`final`; inject `FilesystemFactory` + `ConfigRepository`). |
| **`Banulakwin\SupportHelpers\Contracts\FlexibleCache`** | Contract for flexible-cache strategy. |
| **`Banulakwin\SupportHelpers\Services\FlexibleCacheService`** | Default: `rememberFlexible()` + `shouldUseFlexibleCache()` (production only). `final` in this repo after Pint—**rebind the contract** with your own class if you need different rules (e.g. cache on `staging`). |
| **Helpers** | Thin `app(Contract::class)->…` wrappers for Blade and legacy call sites. |

**Binding your own implementation** (e.g. in `AppServiceProvider`):

```php
use Banulakwin\SupportHelpers\Contracts\PublicImage;
use App\Support\CustomPublicImage;

$this->app->singleton(PublicImage::class, CustomPublicImage::class);
```

Or implement the contract yourself (or wrap the default service) and bind that to the contract.

**Prefer in application code:** constructor injection of `PublicImage` or `FlexibleCache` (or facades if you accept hidden dependencies).

---

## Global functions (delegate to services)

### Images

| Function | Delegates to |
|----------|----------------|
| `defaultPlaceholder()` | `PublicImage::defaultPlaceholder()` |
| `StorageImage(...)` | `PublicImage::storageImage(...)` |
| `normalizePublicRelativePath($path)` | `PublicImage::normalizePublicRelativePath($path)` |
| `ResolvedPublicImage($path)` | `PublicImage::resolvedPublicImage($path)` |
| `AssetImage(...)` | `PublicImage::assetImage(...)` |

### Cache

| Function | Delegates to |
|----------|----------------|
| `CacheData($key, $ttl, $callback)` | `FlexibleCache::rememberFlexible(...)` |

---

## Testing

```bash
composer test          # Run PHPUnit
composer pint          # Fix code style
composer phpstan       # Static analysis
composer quality       # Run all (pint + phpstan + test)
```

---

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for details.

---

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/your-feature`)
3. Run `composer quality` to ensure tests and style pass
4. Commit and push
5. Open a pull request

---

## Package layout

```
config/support-helpers.php
src/Contracts/PublicImage.php
src/Contracts/FlexibleCache.php
src/Services/PublicImageService.php
src/Services/FlexibleCacheService.php
src/Facades/PublicImage.php
src/Facades/FlexibleCache.php
src/SupportHelpersServiceProvider.php
src/helpers.php
```

---

## License

MIT — see [LICENSE](LICENSE) for details.
