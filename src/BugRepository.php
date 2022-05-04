<?php

declare(strict_types=1);

namespace PhperKaig;

use DateTime;
use InvalidArgumentException;
use PDO;

class BugRepository
{
    CONST TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(DateTimeRange $searchRange, Status $status): array
    {
        $sql = 'SELECT bug_id, summary, reported_at FROM Bugs
                WHERE reported_at >= :startAt AND reported_at < :endAt
                AND status = :status';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':startAt', $searchRange->startAt->value()->format(self::TIMESTAMP_FORMAT), PDO::PARAM_STR);
        $stmt->bindValue(':endAt', $searchRange->endAt->value()->format(self::TIMESTAMP_FORMAT), PDO::PARAM_STR);
        $stmt->bindValue(':status', $status->value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Bug::class);
    }
}
