<?php

declare(strict_types=1);

namespace PhperKaig;

use PDO;

class BugRepository
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll($params)
    {
        $sql = 'SELECT bug_id, summary, reported_at FROM Bugs
                WHERE reported_at >= :startAt AND reported_at < :endAt
                AND status = :status';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Bug::class);
    }
}