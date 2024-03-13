# 1D Geometry
1D geometry for PHP 8.1+

## Geometry Intersections Documentation

The `Geometry\Intersects` provides functionalities to determine the intersections between various 1D geometric entities such as points, segments, and vectors.

## Shapes

- **Point**: Represents a point in a 1D space.
- **Segment**: Represents a line segment defined by two endpoints.
- **Vector**: Represents an infinite line starting from a point and extending in a specified direction.

## Example Usages

Below are examples demonstrating how to use each method in the `Geometry` class.

### intersectsPoints Example

```php
// Create two points
$point1 = new Point(1, true);
$point2 = new Point(1, true);

// Check if the points intersect
$result = Intersects::intersectsPoints($point1, $point2);

// Output: true
echo $result ? 'true' : 'false';
```

### intersectsPointAndSegment Example
```php
// Create a point and a segment
$point = new Point(2, true);
$segment = new Segment(new Point(1, true), new Point(3, true));

// Check if the point intersects with the segment
$result = Intersects::intersectsPointAndSegment($point, $segment);

// Output: true
echo $result ? 'true' : 'false';
```

### intersectsPointAndVector Example
```php
// Create a point and a vector
$point = new Point(5, true);
$vector = new Vector(new Point(2, true), true);

// Check if the point intersects with the vector
$result = Intersects::intersectsPointAndVector($point, $vector);

// Output: true
echo $result ? 'true' : 'false';
```

### intersectsSegments Example
```php
// Create two segments
$segment1 = new Segment(new Point(1, true), new Point(4, true));
$segment2 = new Segment(new Point(3, true), new Point(5, true));

// Check if the segments intersect
$result = Intersects::intersectsSegments($segment1, $segment2);

// Output: true
echo $result ? 'true' : 'false';
```

### intersectsSegmentAndVector Example
```php
// Create a segment and a vector
$segment = new Segment(new Point(1, true), new Point(3, true));
$vector = new Vector(new Point(2, true), true);

// Check if the segment intersects with the vector
$result = Intersects::intersectsSegmentAndVector($segment, $vector);

// Output: true
echo $result ? 'true' : 'false';
```

### intersectsVectors Example
```php
// Create two vectors
$vector1 = new Vector(new Point(0, true), true);
$vector2 = new Vector(new Point(2, true), false);

// Check if the vectors intersect
$result = Intersects::intersectsVectors($vector1, $vector2);

// Output: true (since both vectors are infinite in one direction, they intersect)
echo $result ? 'true' : 'false';
```

These examples provide a practical guide on how to use each method in your `Intersects` class, showcasing the creation of `Point`, `Segment`, and `Vector` objects and how they can be used to check for intersections.