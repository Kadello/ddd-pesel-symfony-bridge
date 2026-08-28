<?php

declare(strict_types=1);

namespace App\PeselBundle\Domain;

use DateTimeImmutable;
use InvalidArgumentException;

final readonly class Pesel
{
    private const array WEIGHTS = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];

    public function __construct(public string $value)
    {
        if (!preg_match('/^\d{11}$/', $value)) {
            throw new InvalidArgumentException('PESEL musi składać się z dokładnie 11 cyfr.');
        }

        if (!$this->hasValidChecksum($value)) {
            throw new InvalidArgumentException('Nieprawidłowa cyfra kontrolna numeru PESEL.');
        }
    }

    private function hasValidChecksum(string $pesel): bool
    {
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += (int) $pesel[$i] * self::WEIGHTS[$i];
        }

        $controlDigit = (10 - ($sum % 10)) % 10;

        return $controlDigit === (int) $pesel[10];
    }

    public function getBirthDate(): DateTimeImmutable
    {
        $year = (int) substr($this->value, 0, 2);
        $month = (int) substr($this->value, 2, 2);
        $day = (int) substr($this->value, 4, 2);

        if ($month > 80) {
            $year += 1800;
            $month -= 80;
        } elseif ($month > 60) {
            $year += 2200;
            $month -= 60;
        } elseif ($month > 40) {
            $year += 2100;
            $month -= 40;
        } elseif ($month > 20) {
            $year += 2000;
            $month -= 20;
        } else {
            $year += 1900;
        }

        return new DateTimeImmutable(sprintf('%04d-%02d-%02d', $year, $month, $day));
    }

    public function getGender(): string
    {
        return ((int) $this->value[9] % 2 === 0) ? 'female' : 'male';
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
