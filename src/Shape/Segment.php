<?php declare(strict_types=1);

namespace AP\Geo\OneD\Shape;

class Segment
{
    public function __construct(
        public Point $point1,
        public Point $point2,
    )
    {
    }

    public function min(): Point
    {
        if ($this->point1->value == $this->point2->value) {
            return $this->point1->inclusive || !$this->point2->inclusive ?
                $this->point1 : $this->point2;
        }

        return $this->point1->value < $this->point2->value ?
            $this->point1 : $this->point2;
    }

    public function max(): Point
    {
        if ($this->point1->value == $this->point2->value) {
            return $this->point2->inclusive || !$this->point1->inclusive ?
                $this->point2 : $this->point1;
        }

        return $this->point2->value > $this->point1->value ?
            $this->point2 : $this->point1;
    }
}