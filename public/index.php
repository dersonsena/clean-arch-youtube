<?php

use App\Application\Usecases\ExportRegistration\ExportRegistration;
use App\Application\Usecases\ExportRegistration\InputBoundary;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Repositories\MySQL\PdoRegistrationRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$appConfig = require_once __DIR__ . '/../config/app.php';

// Entities

$registration = new Registration();

$registration->setName('Kilderson Sena')
    ->setBirthDate(new DateTimeImmutable('1988-02-14'))
    ->setEmail(new Email('dersonsena@gmail.com'))
    ->setRegistrationAt(new DateTimeImmutable())
    ->setRegistrationNumber(new Cpf('01234567890'));



// Use cases
$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $appConfig['db']['host'],
    $appConfig['db']['port'],
    $appConfig['db']['dbname'],
    $appConfig['db']['charset']
);

$pdo = new PDO($dsn, $appConfig['db']['username'], $appConfig['db']['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_PERSISTENT => TRUE
]);

$loadRegistrationRepo = new PdoRegistrationRepository($pdo);
$pdfExporter = new Html2PdfAdapter();
$storage = new LocalStorageAdapter();

$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepo, $pdfExporter, $storage);
$inputBoundary = new InputBoundary('01234567890', 'xpto', __DIR__ . '/../storage');
$output = $exportRegistrationUseCase->handle($inputBoundary);
