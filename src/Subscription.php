<?php

declare(strict_types=1);

namespace PhperKaigi;

use DateInterval;
use Stringable;

class Subscription implements Stringable
{
    public function __construct(
        private readonly string $name,
        private readonly DateTimeRange $range,
    ) {}

    public function __toString(): string
    {
        $startAt = $this->range->startAt->value();
        $endAt = $this->range->endAt->value();
        return $this->name . '(' . $startAt->format('Y-m-d') . ' -> ' . $endAt->format('Y-m-d') . ')';
    }

    public function renew(): Subscription
    {
        $oneYear = DateInterval::createFromDateString('1 year');
        $startAt = $this->range->startAt;
        $endAt = $this->range->endAt;
        return new Subscription(
            name: $this->name,
            range: new DateTimeRange(
                startAt: new DateTimeEndpoint(
                    value: $startAt->value()->add($oneYear),
                    inclusive: $startAt->inclusive
                ),
                endAt: new DateTimeEndpoint(
                    value: $endAt->value()->add($oneYear),
                    inclusive: $endAt->inclusive
                )
            )
        );
    }
}
