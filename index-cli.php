<?php

use App\Application\Usecases\ExportRegistration\ExportRegistration;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Infra\Adapters\DomPdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Cli\Commands\ExportRegistrationCommand;
use App\Infra\Presentation\ExportRegistrationPresenter;
use App\Infra\Repositories\MySQL\PdoRegistrationRepository;

ini_set('display_errors', 'off');

require_once __DIR__ . '/vendor/autoload.php';

$appConfig = require_once __DIR__ . '/config/app.php';

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
//$pdfExporter = new Html2PdfAdapter();
$pdfExporter = new DomPdfAdapter();
$storage = new LocalStorageAdapter();

$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepo, $pdfExporter, $storage);
$exportRegistrationCommand = new ExportRegistrationCommand($exportRegistrationUseCase);
$exportRegistrationPresenter = new ExportRegistrationPresenter();

echo $exportRegistrationCommand->handle($exportRegistrationPresenter);
