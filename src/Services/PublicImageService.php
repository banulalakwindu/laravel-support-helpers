<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Services;

use Banulakwin\SupportHelpers\Contracts\PublicImage as PublicImageContract;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Filesystem\FilesystemAdapter;

final class PublicImageService implements PublicImageContract
{
    public function __construct(
        private FilesystemFactory $storage,
        private ConfigRepository $config,
    ) {}

    public function defaultPlaceholder(): string
    {
        $base = $this->stringConfig('support-helpers.image.placeholder_base');
        $appName = $this->stringConfig('app.name');

        return $base . urlencode($appName);
    }

    public function storageImage(
        ?string $path,
        ?string $placeholder = null,
        bool $isAvatar = false,
        string $name = 'avatar',
    ): ?string {
        $disk = $this->stringConfig('support-helpers.image.disk', 'public');
        $avatarBase = $this->stringConfig('support-helpers.image.avatar_placeholder_base');
        $placeholder ??= $this->defaultPlaceholder();
        $diskInstance = $this->storage->disk($disk);

        if (! $diskInstance instanceof FilesystemAdapter) {
            return $isAvatar ? $avatarBase . urlencode($name) : null;
        }

        if ($isAvatar) {
            return $path && $diskInstance->exists($path)
                ? $diskInstance->url($path)
                : $avatarBase . urlencode($name);
        }

        return $path && $diskInstance->exists($path)
            ? $diskInstance->url($path)
            : null;
    }

    public function normalizePublicRelativePath(string $path): string
    {
        return mb_ltrim(str_replace('\\', '/', $path), '/');
    }

    public function resolvedPublicImage(?string $path): ?string
    {
        if ($path === null || mb_trim($path) === '') {
            return null;
        }

        $path = mb_trim($path);

        if (filter_var($path, FILTER_VALIDATE_URL) !== false) {
            return $path;
        }

        $fromStorage = $this->storageImage($path, null, false, 'avatar');
        if ($fromStorage !== null) {
            return $fromStorage;
        }

        $relative = $this->normalizePublicRelativePath($path);
        if ($relative !== '' && file_exists(public_path($relative))) {
            return asset($relative);
        }

        return null;
    }

    public function assetImage(
        ?string $path,
        ?string $placeholder = null,
        bool $isAvatar = false,
        string $name = 'avatar',
    ): string {
        $placeholder ??= $this->defaultPlaceholder();
        $avatarBase = $this->stringConfig('support-helpers.image.avatar_placeholder_base');

        if ($path === null || mb_trim($path) === '') {
            return $isAvatar
                ? $avatarBase . urlencode($name)
                : $placeholder;
        }

        $relative = $this->normalizePublicRelativePath($path);

        if ($isAvatar) {
            return $relative !== '' && file_exists(public_path($relative))
                ? asset($relative)
                : $avatarBase . urlencode($name);
        }

        return $relative !== '' && file_exists(public_path($relative))
            ? asset($relative)
            : $placeholder;
    }

    private function stringConfig(string $key, string $default = ''): string
    {
        $value = $this->config->get($key, $default);

        return is_string($value) ? $value : $default;
    }
}
