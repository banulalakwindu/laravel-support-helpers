<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Tests\Unit;

use Banulakwin\SupportHelpers\Contracts\FlexibleCache as FlexibleCacheContract;
use Banulakwin\SupportHelpers\Contracts\PublicImage as PublicImageContract;
use Banulakwin\SupportHelpers\Services\FlexibleCacheService;
use Banulakwin\SupportHelpers\Services\PublicImageService;
use Banulakwin\SupportHelpers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ServiceProviderTest extends TestCase
{
    #[Test]
    public function it_publishes_config(): void
    {
        $this->assertFileExists(__DIR__ . '/../../config/support-helpers.php');
    }

    #[Test]
    public function it_registers_public_image_contract(): void
    {
        $this->assertInstanceOf(
            PublicImageContract::class,
            app(PublicImageContract::class)
        );
    }

    #[Test]
    public function it_registers_public_image_service(): void
    {
        $this->assertInstanceOf(
            PublicImageService::class,
            app(PublicImageService::class)
        );
    }

    #[Test]
    public function it_registers_flexible_cache_contract(): void
    {
        $this->assertInstanceOf(
            FlexibleCacheContract::class,
            app(FlexibleCacheContract::class)
        );
    }

    #[Test]
    public function it_registers_flexible_cache_service(): void
    {
        $this->assertInstanceOf(
            FlexibleCacheService::class,
            app(FlexibleCacheService::class)
        );
    }
}
