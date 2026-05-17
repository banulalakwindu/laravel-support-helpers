<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Tests\Unit;

use Banulakwin\SupportHelpers\Contracts\PublicImage as PublicImageContract;
use Banulakwin\SupportHelpers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PublicImageServiceTest extends TestCase
{
    #[Test]
    public function it_returns_default_placeholder(): void
    {
        $this->app['config']->set('app.name', 'TestApp');
        $this->app['config']->set('support-helpers.image.placeholder_base', 'https://placehold.co/800x600/733E0A/FDC700?text=');

        $result = app(PublicImageContract::class)->defaultPlaceholder();

        $this->assertEquals('https://placehold.co/800x600/733E0A/FDC700?text=TestApp', $result);
    }

    #[Test]
    public function it_normalizes_public_relative_paths(): void
    {
        $result = app(PublicImageContract::class)->normalizePublicRelativePath('/images/test.jpg');

        $this->assertEquals('images/test.jpg', $result);
    }

    #[Test]
    public function it_normalizes_paths_with_backslashes(): void
    {
        $result = app(PublicImageContract::class)->normalizePublicRelativePath('\\images\\test.jpg');

        $this->assertEquals('images/test.jpg', $result);
    }

    #[Test]
    public function it_returns_null_for_empty_path_in_resolved_public_image(): void
    {
        $result = app(PublicImageContract::class)->resolvedPublicImage(null);

        $this->assertNull($result);
    }

    #[Test]
    public function it_returns_null_for_whitespace_path_in_resolved_public_image(): void
    {
        $result = app(PublicImageContract::class)->resolvedPublicImage('   ');

        $this->assertNull($result);
    }

    #[Test]
    public function it_returns_absolute_urls_unchanged_in_resolved_public_image(): void
    {
        $url = 'https://example.com/image.jpg';
        $result = app(PublicImageContract::class)->resolvedPublicImage($url);

        $this->assertEquals($url, $result);
    }

    #[Test]
    public function it_returns_placeholder_for_null_path_in_asset_image(): void
    {
        $this->app['config']->set('app.name', 'TestApp');
        $this->app['config']->set('support-helpers.image.placeholder_base', 'https://placehold.co/800x600/733E0A/FDC700?text=');

        $result = app(PublicImageContract::class)->assetImage(null);

        $this->assertEquals('https://placehold.co/800x600/733E0A/FDC700?text=TestApp', $result);
    }

    #[Test]
    public function it_returns_avatar_placeholder_for_null_path_in_asset_image(): void
    {
        $this->app['config']->set('support-helpers.image.avatar_placeholder_base', 'https://ui-avatars.com/api/?name=');

        $result = app(PublicImageContract::class)->assetImage(null, null, true, 'John Doe');

        $this->assertEquals('https://ui-avatars.com/api/?name=John+Doe', $result);
    }
}
