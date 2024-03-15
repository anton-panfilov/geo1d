<?php declare(strict_types=1);

namespace AP\Geo\OneD\Shape;

class Point extends AbstractShape
{
    public function __construct(
        public int|float $value,
        public bool $inclusive
    )
    {
    }
}