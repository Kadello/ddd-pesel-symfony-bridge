<?php

declare(strict_types=1);

namespace App\PeselBundle\Tests\Form;

use App\PeselBundle\Domain\Pesel;
use App\PeselBundle\Form\PeselType;
use Symfony\Component\Form\Test\TypeTestCase;

final class PeselTypeTest extends TypeTestCase
{
    public function testSubmitValidDataAsString(): void
    {
        $form = $this->factory->create(PeselType::class, null, [
            'as_object' => false,
        ]);

        $form->submit('44051401358');

        $this->assertTrue($form->isSynchronized());
        $this->assertSame('44051401358', $form->getData());
    }

    public function testSubmitValidDataAsObject(): void
    {
        $form = $this->factory->create(PeselType::class, null, [
            'as_object' => true,
        ]);

        $form->submit('44051401358');

        $this->assertTrue($form->isSynchronized());

        $data = $form->getData();
        $this->assertInstanceOf(Pesel::class, $data);
        $this->assertSame('44051401358', $data->value);
    }
}