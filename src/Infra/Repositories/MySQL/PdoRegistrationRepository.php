<?php

declare(strict_types=1);

namespace App\Infra\Repositories\MySQL;

use App\Domain\Entities\Registration;
use App\Domain\Exceptions\RegistrationNotFoundException;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use DateTimeImmutable;
use PDO;

final class PdoRegistrationRepository implements LoadRegistrationRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function loadByRegistrationNumber(Cpf $cpf): Registration
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM `registrations` WHERE registration_number = :cpf"
        );

        $statement->execute([':cpf' => (string)$cpf]);
        $record = $statement->fetch();

        if (!$record) {
            throw new RegistrationNotFoundException($cpf);
        }

        $values = [
            'name' => $record['name'],
            'birth_date' => new DateTimeImmutable($record['birth_date']),
            'email' => new Email($record['email']),
            'registration_at' => new DateTimeImmutable($record['created_at']),
            'registration_number' => new Cpf($record['registration_number'])
        ];

        return Registration::create($values);
    }
}
