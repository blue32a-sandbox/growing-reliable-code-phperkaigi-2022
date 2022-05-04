<?php

declare(strict_types=1);

namespace Tests;

use PhperKaigi\DateTimeEndpoint;
use PhperKaigi\DateTimeRange;
use PhperKaigi\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testRenew(): void
    {
        $year2021 = new DateTimeRange(
            startAt: DateTimeEndpoint::icluding('2021-01-01'),
            endAt: DateTimeEndpoint::excluding('2022-01-01')
        );
        $phpstorm = new Subscription('PhpStorm', $year2021);
        $this->assertSame('PhpStorm(2021-01-01 -> 2022-01-01)', strval($phpstorm));

        $pycharm = new Subscription('PyCharm', $year2021);
        $this->assertSame('PyCharm(2021-01-01 -> 2022-01-01)', strval($pycharm));

        $phpstorm2022 = $phpstorm->renew();
        $this->assertSame('PhpStorm(2022-01-01 -> 2023-01-01)', strval($phpstorm2022));
        $this->assertSame('PhpStorm(2021-01-01 -> 2022-01-01)', strval($phpstorm));
        $this->assertSame('PyCharm(2021-01-01 -> 2022-01-01)', strval($pycharm));
    }
}
