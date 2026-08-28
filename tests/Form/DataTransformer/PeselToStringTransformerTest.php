<?php

declare(strict_types=1);

namespace App\PeselBundle\Tests\Form\DataTransformer;

use App\PeselBundle\Domain\Pesel;
use App\PeselBundle\Form\DataTransformer\PeselToStringTransformer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class PeselToStringTransformerTest extends TestCase
{
    private PeselToStringTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new PeselToStringTransformer();
    }

    public function testTransform(): void
    {
        $pesel = new Pesel('44051401342');

        $this->assertSame('', $this->transformer->transform(null));
        $this->assertSame('44051401342', $this->transformer->transform($pesel));
        $this->assertSame('44051401342', $this->transformer->transform('44051401342'));
    }

    public function testReverseTransformValidValue(): void
    {
        $this->assertNull($this->transformer->reverseTransform(null));
        $this->assertNull($this->transformer->reverseTransform('   '));

        $result = $this->transformer->reverseTransform('44051401342');
        $this->assertInstanceOf(Pesel::class, $result);
        $this->assertSame('44051401342', $result->value);
    }

    public function testReverseTransformInvalidValueThrowsTransformationFailedException(): void
    {
        $this->expectException(TransformationFailedException::class);
        $this->transformer->reverseTransform('invalid-pesel');
    }
}
