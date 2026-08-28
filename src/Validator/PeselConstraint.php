<?php

declare(strict_types=1);

namespace App\PeselBundle\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class PeselConstraint extends Constraint
{
    public string $message = 'Wartość "{{ value }}" nie jest prawidłowym numerem PESEL.';
}