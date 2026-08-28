# Symfony PESEL Bundle

[![CI](https://github.com/twoj-nick/pesel-bundle/actions/workflows/ci.yml/badge.svg)](https://github.com/twoj-nick/pesel-bundle/actions)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.3-8892BF.svg)](https://php.net)

Lightweight, production-ready Symfony Bundle bridging pure Domain-Driven Design (PESEL Value Object) with Symfony Framework components (Validator & Form Types).

## Features

* **DDD Value Object (`Pesel`)**: Immutable object validating length and checksum, extracting birth date (with 1800–2299 century support), and gender.
* **Symfony Validator (`#[PeselConstraint]`)**: Native attribute constraint for Entity and DTO validation.
* **Symfony Form Type (`PeselType`)**: Built-in `DataTransformer` mapping raw string inputs directly to `Pesel` Value Objects.
* **Strict Quality**: Fully covered by PHPUnit test suites and configured for PHPStan MAX level analysis.

## Installation

Install the package via Composer:

```bash
composer require Kadello/pesel-bundle
```

## Usage
1. Domain Value Object

```bash
use App\PeselBundle\Domain\Pesel;

$pesel = new Pesel('44051401342');

echo $pesel->getBirthDate()->format('Y-m-d'); // 1944-05-14
echo $pesel->getGender();                     // female
echo $pesel->value;       
```

## Entity & DTO Validation
  Apply the #[PeselConstraint] attribute directly to properties:
  ```bash
use App\PeselBundle\Validator\PeselConstraint;

class UserDto
{
    #[PeselConstraint]
    public string $pesel;
}
```
## Symfony Form Integration
Use PeselType::class in your form builders:

```bash
use App\PeselBundle\Form\PeselType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array$options): void
    {
        $builder->add('pesel', PeselType::class, [
            'as_object' => true, // Returns Pesel Value Object instead of raw string
        ]);
    }
}
```

# License
The MIT License (MIT).

