<?php

declare(strict_types=1);

namespace Tests;

use DateTimeImmutable;
use DateTimeZone;
use Error;
use PhperKaig\DateTimeEndpoint;
use PHPUnit\Framework\TestCase;

class DateTimeEndpointTest extends TestCase
{
    /**
     * @test
     */
    public function valueのタイムゾーンが異なっても同じ時刻を指している場合は等価とみなす(): void
    {
        $utc = new DateTimeImmutable('2021-12-24T15:00:00+00:00');
        $jst = new DateTimeImmutable('2021-12-25T00:00:00', new DateTimeZone('Asia/Tokyo'));
        $ep1 = new DateTimeEndpoint(value: $utc, inclusive: true);
        $ep2 = new DateTimeEndpoint(value: $jst, inclusive: true);
        $this->assertEquals($ep1, $ep2);
        $this->assertTrue($ep1 == $ep2);
    }

    /**
     * @test
     */
    public function DateTimeEndpointのコンストラクタを2回以上呼び出せないこと(): void
    {
        $dt = new DateTimeImmutable('2020-12-25');
        $endpoint = new DateTimeEndpoint(value: $dt, inclusive: false);
        $newDate = new DateTimeImmutable('2022-01-01');
        try {
            $endpoint->__construct(value: $newDate, inclusive: true);
        } catch (Error $expected) {
            $this->assertSame('Cannot modify readonly property PhperKaig\DateTimeEndpoint::$inclusive', $expected->getMessage());
            return;
        }
        $this->fail('例外が発生していない');
    }

    /**
     * @test
     * @group debugging
     */
    public function 生成時に渡したvalueを後から破壊されても影響を受けないこと(): void
    {
        $dt = new DateTimeImmutable('2020-12-25');
        $endpoint = new DateTimeEndpoint(value: $dt, inclusive: false);
        $this->assertSame('2020-12-25', $endpoint->value()->format('Y-m-d'));

        $dt->__construct('2022-01-01');

        $this->assertSame('2020-12-25', $endpoint->value()->format('Y-m-d'));
    }

    /**
     * @test
     * @group learning
     * @group debugging
     */
    public function readonlyなvalueプロパティのコンストラクタを呼んで破壊できるか(): void
    {
        $dt = new DateTimeImmutable('2020-12-25');
        $endpoint = new DateTimeEndpoint(value: $dt, inclusive: false);
        $this->assertSame('2020-12-25', $endpoint->value()->format('Y-m-d'));

        $endpoint->value()->__construct('2022-01-01');

        $this->assertSame('2020-12-25', $endpoint->value()->format('Y-m-d'));
    }

    /**
     * @test
     * @group debugging
     */
    // public function 悪意あるサブクラスによる破壊(): void
    // {
    //     $ddt = new DestructiveDateTime('2020-12-25', new DateTimeZone('Asia/Tokyo'));

    //     $endpoint = new DateTimeEndpoint(value: $ddt, inclusive: false);
    //     $this->assertSame('2020-12-25T00:00:00+09:00', $endpoint->value()->format('Y-m-d\TH:i:sP'));

    //     DestructiveDateTime::bringEverythingBacktoEpoch();

    //     $this->assertSame('1970-01-01T00:00:00+00:00', $endpoint->value()->format('Y-m-d\TH:i:sP'));
    // }

    /**
     * @test
     * @group debugging
     */
    public function 悪意あるサブクラスによる破壊の影響をうけないこと(): void
    {
        $ddt = new DestructiveDateTime('2020-12-25', new DateTimeZone('Asia/Tokyo'));

        $endpoint = new DateTimeEndpoint(value: $ddt, inclusive: false);
        $this->assertSame('2020-12-25T00:00:00+09:00', $endpoint->value()->format('Y-m-d\TH:i:sP'));

        DestructiveDateTime::bringEverythingBacktoEpoch();

        $this->assertSame('1970-01-01T00:00:00+00:00', $ddt->format('Y-m-d\TH:i:sP'));
        $this->assertSame('2020-12-25T00:00:00+09:00', $endpoint->value()->format('Y-m-d\TH:i:sP'));
    }

    /**
     * @test
     * @group learning
     */
    // public function cloneはシャローコピーなので参照を共有してしまう(): void
    // {
    //     $dt = new TimeZoneCachingDateTime('2020-12-25', new DateTimeZone('Asia/Tokyo'));
    //     $endpiont = new DateTimeEndpoint(value: $dt, inclusive: false);

    //     $this->assertSame('Asia/Tokyo', $endpiont->value()->getTimezone()->getName());

    //     $endpiont->value()->getTimezone()->__construct('Europe/Berlin');

    //     $this->assertSame('Europe/Berlin', $endpiont->value()->getTimezone()->getName());
    // }

    /**
     * @test
     * @group debugging
     */
    public function 参照の共有による副作用を生じないこと(): void
    {
        $tcdt = new TimeZoneCachingDateTime('2020-12-25', new DateTimeZone('Asia/Tokyo'));
        $endpiont = new DateTimeEndpoint(value: $tcdt, inclusive: false);

        $this->assertSame('Asia/Tokyo', $endpiont->value()->getTimezone()->getName());

        $endpiont->value()->getTimezone()->__construct('Europe/Berlin');

        $this->assertSame('Asia/Tokyo', $endpiont->value()->getTimezone()->getName());
    }
}
