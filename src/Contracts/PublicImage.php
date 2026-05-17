<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Contracts;

interface PublicImage
{
    public function defaultPlaceholder(): string;

    public function storageImage(
        ?string $path,
        ?string $placeholder = null,
        bool $isAvatar = false,
        string $name = 'avatar',
    ): ?string;

    public function normalizePublicRelativePath(string $path): string;

    public function resolvedPublicImage(?string $path): ?string;

    public function assetImage(
        ?string $path,
        ?string $placeholder = null,
        bool $isAvatar = false,
        string $name = 'avatar',
    ): string;
}
