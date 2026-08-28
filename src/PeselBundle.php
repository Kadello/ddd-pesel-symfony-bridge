<?php

declare(strict_types=1);

namespace App\PeselBundle;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class PeselBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}