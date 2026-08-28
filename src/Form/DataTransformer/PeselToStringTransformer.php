<?php

declare(strict_types=1);

namespace App\PeselBundle\Form\DataTransformer;

use App\PeselBundle\Domain\Pesel;
use InvalidArgumentException;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @implements DataTransformerInterface<Pesel, string>
 */
final class PeselToStringTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): string
    {
        if (null === $value) {
            return '';
        }

        if ($value instanceof Pesel) {
            return $value->value;
        }

        return (string) $value;
    }

    public function reverseTransform(mixed $value): ?Pesel
    {
        if (null === $value || '' === trim((string) $value)) {
            return null;
        }

        try {
            return new Pesel((string) $value);
        } catch (InvalidArgumentException $e) {
            throw new TransformationFailedException($e->getMessage(), 0, $e);
        }
    }
}