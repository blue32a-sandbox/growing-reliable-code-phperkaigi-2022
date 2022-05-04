<?php

declare(strict_types=1);

namespace Tests;

use InvalidArgumentException;
use PhperKaigi\DateTimeEndpoint;
use PhperKaigi\DateTimeRange;
use PHPUnit\Framework\TestCase;
use Tests\DateTimeShorthandHelper as DT;

class DateTimeRangeTest extends TestCase
{
    /**
     * @test
     */
    public function 終了日時が開始日時より前の場合は例外が発生する(): void
    {
        $startAt = DateTimeEndpoint::icluding(DT::jst('2021-12-25'));
        $endAt = DateTimeEndpoint::excluding(DT::jst('2021-12-24'));

        $this->expectException(InvalidArgumentException::class);
        new DateTimeRange($startAt, $endAt);
    }

    /**
     * @test
     */
    public function 上端点と下端点が同じ場合は例外が発生する(): void
    {
        $startAt = DateTimeEndpoint::icluding(DT::jst('2021-12-25'));
        $endAt = DateTimeEndpoint::excluding(DT::jst('2021-12-24'));

        $this->expectException(InvalidArgumentException::class);
        new DateTimeRange($startAt, $endAt);
    }
}
