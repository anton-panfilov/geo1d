<?php declare(strict_types=1);

namespace AP\Geo\OneD\Shape;

class Point
{
    public function __construct(
        public int|float $value,
        public bool $inclusive
    )
    {
    }
}