<?php

declare(strict_types=1);

namespace App\PeselBundle\Form;

use App\PeselBundle\Form\DataTransformer\PeselToStringTransformer;
use App\PeselBundle\Validator\PeselConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PeselType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['as_object']) {
            $builder->addModelTransformer(new PeselToStringTransformer());
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'as_object' => false,
            'constraints' => [
                new PeselConstraint(),
            ],
        ]);

        $resolver->setAllowedTypes('as_object', 'bool');
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}