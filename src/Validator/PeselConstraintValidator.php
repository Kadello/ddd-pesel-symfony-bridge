<?php

declare(strict_types=1);

namespace App\PeselBundle\Validator;

use App\PeselBundle\Domain\Pesel;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class PeselConstraintValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PeselConstraint) {
            throw new UnexpectedTypeException($constraint, PeselConstraint::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        try {
            new Pesel((string) $value);
        } catch (InvalidArgumentException $e) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string) $value)
                ->addViolation();
        }
    }
}