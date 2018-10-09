<?php

declare(strict_types = 1);

namespace Staffer\Domain\FactoryInterfaces;

use Staffer\Domain\ValueObjects\Staff;

/**
 * Interface StaffFactoryInterface
 */
interface StaffFactoryInterface
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $phoneNumber1
     * @param string $phoneNumber2
     * @param string $comments
     *
     * @return Staff
     */
    public function make(
        string $firstName,
        string $lastName,
        string $email,
        string $phoneNumber1,
        string $phoneNumber2,
        string $comments
    ) : Staff;

    /**
     * @param array $csvData
     *
     * @return Staff
     */
    public function makeFromCsvArray(array $csvData) : Staff;

    /**
     * @param array $dbRow
     *
     * @return Staff
     */
    public function makeFromDbArray(array $dbRow) : Staff;
}
