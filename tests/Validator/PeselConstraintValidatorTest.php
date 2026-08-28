<?php

declare(strict_types=1);

namespace App\PeselBundle\Tests\Validator;

use App\PeselBundle\Domain\Pesel;
use App\PeselBundle\Validator\PeselConstraint;
use App\PeselBundle\Validator\PeselConstraintValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

final class PeselConstraintValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new PeselConstraintValidator();
    }

    public function testNullAndEmptyStringAreValid(): void
    {
        $this->validator->validate(null, new PeselConstraint());
        $this->assertNoViolation();

        $this->validator->validate('', new PeselConstraint());
        $this->assertNoViolation();
    }

    public function testValidPeselStringAndObjectAreValid(): void
    {
        $this->validator->validate('44051401342', new PeselConstraint());
        $this->assertNoViolation();

        $this->validator->validate(new Pesel('44051401342'), new PeselConstraint());
        $this->assertNoViolation();
    }

    public function testInvalidPeselTriggersViolation(): void
    {
        $constraint = new PeselConstraint();
        $this->validator->validate('12345', $constraint);

        $this->buildViolation('Wartość "{{ value }}" nie jest prawidłowym numerem PESEL.')
            ->setParameter('{{ value }}', '12345')
            ->assertRaised();
    }

    public function testInvalidConstraintTypeThrowsException(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->validator->validate('44051401342', new class extends \Symfony\Component\Validator\Constraint {});
    }
}
