<?php

declare(strict_types=1);

namespace Tests;

use DateTimeImmutable;
use DateTimeZone;

class TimeZoneCachingDateTime extends DateTimeImmutable
{
    private readonly ?DateTimeZone $tz;

    public function __construct($datetime, $timezone = null)
    {
        parent::__construct($datetime, $timezone);
        $this->tz = $timezone;
    }

    public function getTimezone(): DateTimeZone|false
    {
        return $this->tz;
    }
}
