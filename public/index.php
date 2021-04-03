<?php

use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;

require_once __DIR__ . '/../vendor/autoload.php';

$registration = new Registration();

$registration->setName('Kilderson Sena')
    ->setBirthDate(new DateTimeImmutable('1988-02-14'))
    ->setEmail(new Email('dersonsena@gmail.com'))
    ->setRegistrationAt(new DateTimeImmutable())
    ->setRegistrationNumber(new Cpf('01234567890'));

echo '<pre>'; print_r($registration);
