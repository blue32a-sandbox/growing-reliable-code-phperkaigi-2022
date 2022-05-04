<?php

declare(strict_types=1);

namespace PhperKaigi;

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
        $startAt = $searchRange->startAt->value();
        $endAt = $searchRange->endAt->value();

        $startAtOp = $searchRange->startAt->inclusive ? '<=' : '<';
        $endAtOp = $searchRange->endAt->inclusive ? '<=' : '<';
        $sql = "SELECT bug_id, summary, reported_at FROM Bugs
            WHERE
                status = :status
                AND :startAt ${startAtOp} reported_at
                AND reported_at ${endAtOp} :endAt";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', $status->value, PDO::PARAM_STR);
        $stmt->bindValue(':startAt', $startAt->format(self::TIMESTAMP_FORMAT), PDO::PARAM_STR);
        $stmt->bindValue(':endAt', $endAt->format(self::TIMESTAMP_FORMAT), PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Bug::class);
    }
}
