<?php

declare(strict_types=1);

namespace PhperKaig;

enum Status: string
{
    case Open = 'OPEN';
    case New = 'NEW';
    case Fixed = 'FIXED';
}
