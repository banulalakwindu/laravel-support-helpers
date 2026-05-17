<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Facades;

use Banulakwin\SupportHelpers\Contracts\PublicImage as PublicImageContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string defaultPlaceholder()
 * @method static string|null storageImage(?string $path, ?string $placeholder = null, bool $isAvatar = false, string $name = 'avatar')
 * @method static string normalizePublicRelativePath(string $path)
 * @method static string|null resolvedPublicImage(?string $path)
 * @method static string assetImage(?string $path, ?string $placeholder = null, bool $isAvatar = false, string $name = 'avatar')
 *
 * @see PublicImageContract
 */
final class PublicImage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PublicImageContract::class;
    }
}
