<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Phone
{
    private string $phone;
    private string $ddd;
    private string $ddi;

    public function __construct(string $phone, string $ddd, string $ddi = '+55')
    {
        $this->checkIfPhoneIsEmptyOrNull($phone);
        $this->checkIfDDDIsEmptyOrNull($ddd);

        $phoneSanitized = (string)preg_replace('/[^a-zA-Z0-9]/', '', $phone);
        $dddSanitized = (string)preg_replace('/[\s+()]/', '', $ddd);
        $ddiSanitized = (string)preg_replace('/[+\s+]/', '', $ddi);

        $this->checkPhoneHas8Or9Chars($phoneSanitized);

        $this->checkIfDDDHasTwoChars($dddSanitized);

        $this->checkIfDDDIsNumeric($dddSanitized);

        $this->checkIfDDIHasTwoChars($ddiSanitized);

        $this->checkIfDDIIsNumeric($ddiSanitized);

        $this->phone = $phoneSanitized;
        $this->ddd = $dddSanitized;
        $this->ddi = $ddiSanitized;
    }

    /**
     * @return bool
     */
    public function isMobile(): bool
    {
        if (strlen($this->phone) > 8) {
            return true;
        }

        return false;
    }

    public function __toString(): string
    {
        return $this->ddi . $this->ddd . $this->phone;
    }

    private function checkIfPhoneIsEmptyOrNull(string $phone)
    {
        if (is_null($phone) || empty($phone)) {
            throw new InvalidArgumentException("Phone number cannot be empty or null.");
        }
    }

    private function checkIfDDDIsEmptyOrNull(string $ddd)
    {
        if (is_null($ddd) || empty($ddd)) {
            throw new InvalidArgumentException("DDD cannot be empty or null.");
        }
    }

    /**
     * @param string $phone
     */
    private function checkPhoneHas8Or9Chars(string $phone): void
    {
        if (strlen($phone) < 8 || strlen($phone) > 9) {
            throw new InvalidArgumentException('Phone "' . $phone . '" number must be 8 or 9 digits');
        }
    }

    /**
     * @param string $ddd
     */
    private function checkIfDDDHasTwoChars(string $ddd): void
    {
        if (strlen($ddd) !== 2) {
            throw new InvalidArgumentException('DDD must be only 2 characters.');
        }
    }

    /**
     * @param string $ddd
     */
    private function checkIfDDDIsNumeric(string $ddd): void
    {
        if (!is_numeric($ddd)) {
            throw new InvalidArgumentException('DDD must be numeric.');
        }
    }

    /**
     * @param string $ddi
     */
    private function checkIfDDIHasTwoChars(string $ddi): void
    {
        if (strlen($ddi) !== 2) {
            throw new InvalidArgumentException('DDI must be only 2 characters.');
        }
    }

    /**
     * @param string $ddi
     */
    private function checkIfDDIIsNumeric(string $ddi): void
    {
        if (!is_numeric($ddi)) {
            throw new InvalidArgumentException('DDI must be numeric.');
        }
    }
}
