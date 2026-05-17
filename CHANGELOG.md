# Changelog

All notable changes to `banulakwin/laravel-support-helpers` will be documented in this file.

## 1.0.0 — 2026-05-17

### Added
- Global helpers: `CacheData`, `StorageImage`, `AssetImage`, `ResolvedPublicImage`, `normalizePublicRelativePath`, `defaultPlaceholder`.
- Services: `FlexibleCacheService`, `PublicImageService` with contracts + facades `FlexibleCache`, `PublicImage`.
- Config `support-helpers` for disk, placeholder URLs, and avatar placeholder base.
- Publish tag: `support-helpers-config`.
- PHPUnit test suite with Orchestra Testbench.
- GitHub Actions CI workflow (tests, Pint, PHPStan).
- Laravel Pint code style configuration.
- PHPStan static analysis (level max).
