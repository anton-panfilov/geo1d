<?php declare(strict_types=1);

namespace AP\Geo\OneD\Geometry;

use AP\Geo\OneD\Shape\Point;
use AP\Geo\OneD\Shape\Segment;
use AP\Geo\OneD\Shape\Vector;

class Intersects
{
    public static function intersectsPoints(Point $point1, Point $point2): bool
    {
        return $point1->inclusive && $point2->inclusive && $point1->value == $point2->value;
    }

    public static function intersectsPointAndSegment(Point $point, Segment $segment): bool
    {
        $min = min($segment->point1->value, $segment->point2->value);
        $max = max($segment->point1->value, $segment->point2->value);

        if ($point->value < $min || $point->value > $max) {
            return false;
        }

        if ($point->value == $min) {
            return $segment->point1->inclusive && $point->inclusive;
        }

        if ($point->value == $max) {
            return $segment->point2->inclusive && $point->inclusive;
        }

        return true;
    }

    public static function intersectsPointAndVector(Point $point, Vector $vector): bool
    {
        if ($vector->directionTowardsPositiveInfinity) {
            return $point->value > $vector->point->value || ($point->value == $vector->point->value && $vector->point->inclusive && $point->inclusive);
        } else {
            return $point->value < $vector->point->value || ($point->value == $vector->point->value && $vector->point->inclusive && $point->inclusive);
        }
    }

    public static function intersectsSegments(Segment $segment1, Segment $segment2): bool
    {
        $s1Min = min($segment1->point1->value, $segment1->point2->value);
        $s1Max = max($segment1->point1->value, $segment1->point2->value);
        $s2Min = min($segment2->point1->value, $segment2->point2->value);
        $s2Max = max($segment2->point1->value, $segment2->point2->value);

        if ($s1Max < $s2Min || $s2Max < $s1Min) {
            return false;
        }

        if ($s1Min == $s2Max) {
            return $segment1->point1->inclusive && $segment2->point2->inclusive;
        }

        if ($s1Max == $s2Min) {
            return $segment1->point2->inclusive && $segment2->point1->inclusive;
        }

        return true;
    }

    public static function intersectsSegmentAndVector(Segment $segment, Vector $vector): bool
    {
        if ($vector->directionTowardsPositiveInfinity) {
            $segmentMaxPoint = $segment->max();
            return $segmentMaxPoint->value == $vector->point->value ?
                self::intersectsPoints($vector->point, $segmentMaxPoint) :
                $segmentMaxPoint->value > $vector->point->value;
        } else {
            $segmentMinPoint = $segment->min();
            return $segmentMinPoint->value == $vector->point->value ?
                self::intersectsPoints($vector->point, $segmentMinPoint) :
                $segmentMinPoint->value < $vector->point->value;
        }
    }

    public static function intersectsVectors(Vector $vector1, Vector $vector2): bool
    {
        if ($vector1->directionTowardsPositiveInfinity == $vector2->directionTowardsPositiveInfinity) {
            return true; // if vectors directions one way, they intersect
        }

        if ($vector1->point->value == $vector2->point->value) {
            return self::intersectsPoints($vector1->point, $vector2->point);
        }

        return $vector1->directionTowardsPositiveInfinity ?
            $vector1->point->value < $vector2->point->value :
            $vector2->point->value < $vector1->point->value;
    }

//    public static function intersectsVectors(Vector $vector1, Vector $vector2): bool
//    {
//        if ($vector1->directionTowardsPositiveInfinity == $vector2->directionTowardsPositiveInfinity) {
//            if ($vector1->directionTowardsPositiveInfinity) {
//                return $vector1->point->value <= $vector2->point->value;
//            } else {
//                return $vector1->point->value >= $vector2->point->value;
//            }
//        }
//
//        return true;
//    }
}