<?php declare(strict_types=1);

namespace AP\Geo\OneD\Tests\Geometry;

use AP\Geo\OneD\Geometry\Intersects;
use AP\Geo\OneD\Shape\Point;
use AP\Geo\OneD\Shape\Segment;
use AP\Geo\OneD\Shape\Vector;
use PHPUnit\Framework\TestCase;

final class IntersectsTest extends TestCase
{
    public function testIntersectsPoints(): void
    {
        $point1 = new Point(value: 1, inclusive: true);
        $point2 = new Point(value: 1, inclusive: true);
        $point3 = new Point(value: 2, inclusive: true);
        $point4 = new Point(value: 1, inclusive: false);

        $this->assertTrue(Intersects::intersectsPoints($point1, $point2));
        $this->assertFalse(Intersects::intersectsPoints($point1, $point3));
        $this->assertFalse(Intersects::intersectsPoints($point1, $point4));
        $this->assertFalse(Intersects::intersectsPoints($point4, $point4));
    }

    public function testIntersectsPointAndSegment(): void
    {
        $pointInclusiveInside        = new Point(value: 2, inclusive: true);
        $pointInclusiveOutside       = new Point(value: 0, inclusive: true);
        $pointUnInclusiveInside      = new Point(value: 2, inclusive: false);
        $pointUnInclusiveOnLimitLeft = new Point(value: 1, inclusive: false);
        $pointInclusiveOnLimitLeft   = new Point(value: 1, inclusive: true);

        $segmentInclusive = new Segment(
            new Point(value: 1, inclusive: true),
            new Point(value: 3, inclusive: true)
        );

        $segmentInclusiveRevert = new Segment(
            new Point(value: 3, inclusive: true),
            new Point(value: 1, inclusive: true)
        );

        $segmentExclusiveLeft = new Segment(
            new Point(value: 1, inclusive: false),
            new Point(value: 3, inclusive: true)
        );

        $segmentExclusiveRight = new Segment(
            new Point(value: 1, inclusive: true),
            new Point(value: 3, inclusive: false)
        );


        $this->assertTrue(Intersects::intersectsPointAndSegment($pointInclusiveInside, $segmentInclusive));
        $this->assertFalse(Intersects::intersectsPointAndSegment($pointInclusiveOutside, $segmentInclusive));
        $this->assertTrue(Intersects::intersectsPointAndSegment($pointUnInclusiveInside, $segmentInclusive));
        $this->assertFalse(Intersects::intersectsPointAndSegment($pointUnInclusiveOnLimitLeft, $segmentInclusive));
        $this->assertTrue(Intersects::intersectsPointAndSegment($pointInclusiveOnLimitLeft, $segmentInclusive));

        $this->assertTrue(Intersects::intersectsPointAndSegment($pointInclusiveInside, $segmentInclusiveRevert));
        $this->assertFalse(Intersects::intersectsPointAndSegment($pointInclusiveOutside, $segmentInclusiveRevert));
        $this->assertTrue(Intersects::intersectsPointAndSegment($pointUnInclusiveInside, $segmentInclusiveRevert));
        $this->assertFalse(Intersects::intersectsPointAndSegment($pointUnInclusiveOnLimitLeft, $segmentInclusiveRevert));
        $this->assertTrue(Intersects::intersectsPointAndSegment($pointInclusiveOnLimitLeft, $segmentInclusiveRevert));

        $this->assertFalse(Intersects::intersectsPointAndSegment($pointUnInclusiveOnLimitLeft, $segmentExclusiveLeft));
        $this->assertFalse(Intersects::intersectsPointAndSegment($pointInclusiveOnLimitLeft, $segmentExclusiveLeft));

        $this->assertFalse(Intersects::intersectsPointAndSegment($pointUnInclusiveOnLimitLeft, $segmentExclusiveRight));
        $this->assertTrue(Intersects::intersectsPointAndSegment($pointInclusiveOnLimitLeft, $segmentExclusiveRight));
    }

    public function testIntersectsPointAndVector(): void
    {
        $point1Inclisive = new Point(1, true);
        $point1Exclusive = new Point(1, false);
        $point3          = new Point(3, false);
        $pointM1         = new Point(-1, false);

        $vectorPositiveInclusive = new Vector(new Point(1, true), true);
        $vectorPositiveExclusive = new Vector(new Point(1, false), true);
        $vectorNegativeInclusive = new Vector(new Point(1, true), false);


        $this->assertTrue(Intersects::intersectsPointAndVector($point1Inclisive, $vectorPositiveInclusive));
        $this->assertFalse(Intersects::intersectsPointAndVector($point1Exclusive, $vectorPositiveInclusive));
        $this->assertTrue(Intersects::intersectsPointAndVector($point3, $vectorPositiveInclusive));
        $this->assertFalse(Intersects::intersectsPointAndVector($pointM1, $vectorPositiveInclusive));

        $this->assertFalse(Intersects::intersectsPointAndVector($point1Inclisive, $vectorPositiveExclusive));
        $this->assertFalse(Intersects::intersectsPointAndVector($point1Exclusive, $vectorPositiveExclusive));
        $this->assertTrue(Intersects::intersectsPointAndVector($point3, $vectorPositiveExclusive));
        $this->assertFalse(Intersects::intersectsPointAndVector($pointM1, $vectorPositiveExclusive));

        $this->assertTrue(Intersects::intersectsPointAndVector($point1Inclisive, $vectorNegativeInclusive));
        $this->assertFalse(Intersects::intersectsPointAndVector($point1Exclusive, $vectorNegativeInclusive));
        $this->assertFalse(Intersects::intersectsPointAndVector($point3, $vectorNegativeInclusive));
        $this->assertTrue(Intersects::intersectsPointAndVector($pointM1, $vectorNegativeInclusive));
    }

    public function testIntersectsSegments(): void
    {
        $segment_2i_5i = new Segment(new Point(2, true), new Point(5, true));
        $segment_1i_10i = new Segment(new Point(1, true), new Point(10, true));
        $segment_1i_2i = new Segment(new Point(1, true), new Point(2, true));
        $segment_1i_2e = new Segment(new Point(1, true), new Point(2, false));
        $segment_1i_3i = new Segment(new Point(1, true), new Point(3, true));
        $segment_1i_3e = new Segment(new Point(1, true), new Point(3, false));
        $segment_3e_5i = new Segment(new Point(3, false), new Point(5, true));


        $this->assertTrue(Intersects::intersectsSegments($segment_2i_5i, $segment_1i_10i));
        $this->assertTrue(Intersects::intersectsSegments($segment_1i_10i, $segment_2i_5i));

        $this->assertTrue(Intersects::intersectsSegments($segment_2i_5i, $segment_1i_2i));

        $this->assertFalse(Intersects::intersectsSegments($segment_1i_2e, $segment_2i_5i));
        $this->assertFalse(Intersects::intersectsSegments($segment_2i_5i, $segment_1i_2e));


        $this->assertTrue(Intersects::intersectsSegments($segment_2i_5i, $segment_1i_3i));
        $this->assertTrue(Intersects::intersectsSegments($segment_2i_5i, $segment_1i_3e));

        $this->assertTrue(Intersects::intersectsSegments($segment_1i_3i, $segment_2i_5i));
        $this->assertTrue(Intersects::intersectsSegments($segment_1i_3e, $segment_2i_5i));

        $this->assertFalse(Intersects::intersectsSegments($segment_1i_3i, $segment_3e_5i));
        $this->assertFalse(Intersects::intersectsSegments($segment_3e_5i, $segment_1i_3i));
    }

    public function testIntersectsSegmentAndVector(): void
    {
        $vector_3i_pos = new Vector(new Point(3, true), true);
        $vector_3i_neg = new Vector(new Point(3, true), false);
        $vector_3e_pos = new Vector(new Point(3, false), true);

        $segment_1i_2i = new Segment(new Point(1, true), new Point(2, true));
        $segment_1i_3i = new Segment(new Point(1, true), new Point(3, true));
        $segment_1i_3e = new Segment(new Point(1, true), new Point(3, false));
        $segment_1i_4e = new Segment(new Point(1, true), new Point(4, false));
        $segment_3e_10e = new Segment(new Point(3, false), new Point(10, false));
        $segment_10e_11e = new Segment(new Point(10, false), new Point(11, false));

        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_1i_2i, $vector_3i_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1i_3i, $vector_3i_pos));
        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_1i_3e, $vector_3i_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1i_4e, $vector_3i_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_3e_10e, $vector_3i_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_10e_11e, $vector_3i_pos));

        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1i_2i, $vector_3i_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1i_3i, $vector_3i_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1i_3e, $vector_3i_neg));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1i_4e, $vector_3i_neg));
        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_3e_10e, $vector_3i_neg));
        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_10e_11e, $vector_3i_neg));

        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_1i_2i, $vector_3e_pos));
        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_1i_3i, $vector_3e_pos));
        $this->assertFalse(Intersects::intersectsSegmentAndVector($segment_1i_3e, $vector_3e_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_1i_4e, $vector_3e_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_3e_10e, $vector_3e_pos));
        $this->assertTrue(Intersects::intersectsSegmentAndVector($segment_10e_11e, $vector_3e_pos));
    }

    public function testIntersectsVectors(): void
    {
        $vector_100i_pos = new Vector(new Point(100, true), true);
        $vector_100e_neg = new Vector(new Point(100, false), false);

        $vector_3i_pos = new Vector(new Point(3, true), true);
        $vector_3i_neg = new Vector(new Point(3, true), false);

        $vector_3e_pos = new Vector(new Point(3, false), true);
        $vector_3e_neg = new Vector(new Point(3, false), false);

        $this->assertTrue(Intersects::intersectsVectors($vector_3i_pos, $vector_100i_pos));
        $this->assertTrue(Intersects::intersectsVectors($vector_100e_neg, $vector_3i_neg));
        $this->assertTrue(Intersects::intersectsVectors($vector_3i_neg, $vector_100e_neg));

        $this->assertTrue(Intersects::intersectsVectors($vector_3i_pos, $vector_3i_neg));
        $this->assertFalse(Intersects::intersectsVectors($vector_3e_pos, $vector_3e_neg));
        $this->assertFalse(Intersects::intersectsVectors($vector_3e_pos, $vector_3i_neg));
    }
}
