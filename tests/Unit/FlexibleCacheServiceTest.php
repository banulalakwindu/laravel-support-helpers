<?php

declare(strict_types=1);

namespace Banulakwin\SupportHelpers\Tests\Unit;

use Banulakwin\SupportHelpers\Contracts\FlexibleCache as FlexibleCacheContract;
use Banulakwin\SupportHelpers\Tests\TestCase;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;

class FlexibleCacheServiceTest extends TestCase
{
    #[Test]
    public function it_returns_callback_result_when_not_in_production(): void
    {
        $this->assertFalse(app(FlexibleCacheContract::class)->shouldUseFlexibleCache());

        $result = app(FlexibleCacheContract::class)->rememberFlexible(
            'test-key',
            new DateTimeImmutable('+1 hour'),
            fn () => 'callback-result'
        );

        $this->assertEquals('callback-result', $result);
    }

    #[Test]
    public function it_runs_callback_directly_in_testing_environment(): void
    {
        $callCount = 0;

        app(FlexibleCacheContract::class)->rememberFlexible(
            'test-key',
            new DateTimeImmutable('+1 hour'),
            function () use (&$callCount) {
                $callCount++;

                return 'result';
            }
        );

        $this->assertEquals(1, $callCount);
    }
}
