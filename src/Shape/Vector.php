<?php declare(strict_types=1);

namespace AP\Geo\OneD\Shape;

class Vector extends AbstractShape
{
    public function __construct(
        public Point $point,
        public bool  $directionTowardsPositiveInfinity
    )
    {
    }
}