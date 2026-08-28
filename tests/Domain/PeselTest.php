<?php

declare(strict_types=1);

namespace App\PeselBundle\Tests\Domain;

use App\PeselBundle\Domain\Pesel;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PeselTest extends TestCase
{
    public function testValidPeselParsingAndGetters(): void
    {
        $peselFemale = new Pesel('44051401342');
        $this->assertSame('44051401342', $peselFemale->value);
        $this->assertSame('1944-05-14', $peselFemale->getBirthDate()->format('Y-m-d'));
        $this->assertSame('female', $peselFemale->getGender());

        $peselMale = new Pesel('02211508911');
        $this->assertSame('2002-01-15', $peselMale->getBirthDate()->format('Y-m-d'));
        $this->assertSame('male', $peselMale->getGender());
    }

    #[DataProvider('invalidPeselProvider')]
    public function testInvalidPeselThrowsException(string $invalidPesel, string $expectedMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        new Pesel($invalidPesel);
    }

    public static function invalidPeselProvider(): array
    {
        return [
            'za krótki' => ['1234567890', 'PESEL musi składać się z dokładnie 11 cyfr.'],
            'za długi' => ['123456789012', 'PESEL musi składać się z dokładnie 11 cyfr.'],
            'zawiera litery' => ['4405140134a', 'PESEL musi składać się z dokładnie 11 cyfr.'],
            'zła cyfra kontrolna' => ['44051401345', 'Nieprawidłowa cyfra kontrolna numeru PESEL.'],
        ];
    }

    public function testEqualityAndToString(): void
    {
        $pesel1 = new Pesel('44051401342');
        $pesel2 = new Pesel('44051401342');
        $pesel3 = new Pesel('02211508911');

        $this->assertTrue($pesel1->equals($pesel2));
        $this->assertFalse($pesel1->equals($pesel3));
        $this->assertSame('44051401342', (string) $pesel1);
    }
}
