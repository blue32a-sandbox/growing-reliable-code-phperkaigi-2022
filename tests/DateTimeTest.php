<?php

declare(strict_types=1);

namespace Tests;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @testdox DateTime と DateTimeImmutable の違いを示す学習テスト
 */
class DateTimeTest extends TestCase
{
    /**
     * @test
     * @group learning
     */
    public function DateTimeのaddは自身の状態を変更しつつ自身を返す(): void
    {
        $halloween = new DateTime('2021-10-31');
        $oneYear = DateInterval::createFromDateString('1 year');

        $halloween2022 = $halloween->add($oneYear);

        $this->assertSame($halloween, $halloween2022);
        $this->assertEquals('2022-10-31', $halloween->format('Y-m-d'));
        $this->assertEquals('2022-10-31', $halloween2022->format('Y-m-d'));
    }

    /**
     * @test
     * @group learning
     */
    public function DateTimeImmutableのaddは自身の状態を変更せず新しい状態を伴う新しいインスタンスを返す(): void
    {
        $halloween = new DateTimeImmutable('2021-10-31');
        $oneYear = DateInterval::createFromDateString('1 year');

        $halloween2022 = $halloween->add($oneYear);

        $this->assertNotSame($halloween, $halloween2022);
        $this->assertEquals('2021-10-31', $halloween->format('Y-m-d'));
        $this->assertEquals('2022-10-31', $halloween2022->format('Y-m-d'));
    }

    /**
     * @test
     * @group learning
     */
    public function コンストラクタをもう一度呼ぶと破壊的変更ができてしまう(): void
    {
        $dt = new DateTimeImmutable('2021-12-24');
        $this->assertSame('2021-12-24', $dt->format('Y-m-d'));

        $dt->__construct('2022-01-01');

        $this->assertSame('2022-01-01', $dt->format('Y-m-d'));
    }
}
