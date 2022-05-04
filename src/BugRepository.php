<?php

declare(strict_types=1);

namespace PhperKaig;

use InvalidArgumentException;
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
        if (is_null($params)) {
            throw new InvalidArgumentException('params should not be null');
        }
        if (!is_array($params)) {
            throw new InvalidArgumentException('params should be an array');
        }
        if (count($params) !== 3) {
            throw new InvalidArgumentException('params should have exact three items');
        }
        if (!array_key_exists('startAt', $params) ||
            !array_key_exists('endAt', $params) ||
            !array_key_exists('status', $params)) {
            throw new InvalidArgumentException('params should have keys "startAt", "endAt" and "status"');
        }
        if (!is_string($params['startAt'])) {
            throw new InvalidArgumentException('params["startAt"] should be a string');
        }
        if (!is_string($params['endAt'])) {
            throw new InvalidArgumentException('params["endAt"] should be a string');
        }
        if (!is_string($params['status'])) {
            throw new InvalidArgumentException('params["status"] should be a string');
        }
        if (!in_array($params['status'], ['OPEN', 'NEW', 'FIXED'], true)) {
            throw new InvalidArgumentException('params["status"] should be in "OPEN","NEW","FIXED"');
        }

        $sql = 'SELECT bug_id, summary, reported_at FROM Bugs
                WHERE reported_at >= :startAt AND reported_at < :endAt
                AND status = :status';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Bug::class);
    }
}
