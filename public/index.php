<?php

use App\Application\Usecases\ExportRegistration\ExportRegistration;
use App\Application\Usecases\ExportRegistration\InputData;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Infra\Adapters\DomPdfAdapter;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Http\Controllers\ExportRegistrationController;
use App\Infra\Presentation\ExportRegistrationPresenter;
use App\Infra\Repositories\MySQL\PdoRegistrationRepository;
use App\Infra\Validation\ExportRegistrationValidation;
use App\Shared\Infra\Validation\Validator;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

//ini_set('display_errors', 'off');

require_once __DIR__ . '/../vendor/autoload.php';

$appConfig = require_once __DIR__ . '/../config/app.php';

// Entities
$registration = Registration::create([
    'name' => 'Kilderson Sena',
    'birth_date' => new DateTimeImmutable('1988-02-14'),
    'email' => new Email('dersonsena@gmail.com'),
    'registrationAt' => new DateTimeImmutable(),
    'registration_number' => new Cpf('01234567890')
]);

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
$request = new Request('GET', 'http://localhost:8080');
$response = new Response();

// Controllers

$exportRegistrationController = new ExportRegistrationController(
    $request,
    $response,
    $exportRegistrationUseCase
);

$exportRegistrationPresenter = new ExportRegistrationPresenter();

$response = $exportRegistrationController->handle($exportRegistrationPresenter);

header('Content-type: ' . $response->getHeaderLine('content-type'));
echo $response->getBody();
