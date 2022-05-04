<?php

declare(strict_types=1);

use PhperKaig\Bug;
use PhperKaig\BugRepository;
use PhperKaig\DateTimeEndpoint;
use PhperKaig\DateTimeRange;
use PhperKaig\Status;
use PHPUnit\Framework\TestCase;

class BugRepositoryTest extends TestCase
{
    private BugRepository $repo;

    public function setUp(): void
    {
        $pdo = new PDO('mysql:host=mysql;dbname=sample', 'root', 'mlrtpd');
        $this->repo = new BugRepository($pdo);
    }

    public function testFindAll(): void
    {
        $range = new DateTimeRange(
            DateTimeEndpoint::icluding('2021-01-01'),
            DateTimeEndpoint::excluding('2022-01-01')
        );
        $bugs = $this->repo->findAll(searchRange: $range, status: Status::Open);
        $this->assertCount(3, $bugs);

        $bug1 = $bugs[0];
        $this->assertInstanceOf(Bug::class, $bug1);
        $this->assertSame(3, $bug1->bug_id);
        $this->assertSame('保存処理でクラッシュする', $bug1->summary);
        $this->assertSame('2021-12-24 17:14:42', $bug1->reported_at);

        $bug2 = $bugs[1];
        $this->assertInstanceOf(Bug::class, $bug2);
        $this->assertSame(4, $bug2->bug_id);
        $this->assertSame('XMLのサポート', $bug2->summary);
        $this->assertSame('2021-12-25 11:53:18', $bug2->reported_at);

        $bug3 = $bugs[2];
        $this->assertInstanceOf(Bug::class, $bug3);
        $this->assertSame(6, $bug3->bug_id);
        $this->assertSame('パフォーマンスの向上', $bug3->summary);
        $this->assertSame('2021-12-27 13:24:19', $bug3->reported_at);
    }
}
