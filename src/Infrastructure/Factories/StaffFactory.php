<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Factories;

use InvalidArgumentException;
use Staffer\Domain\FactoryInterfaces\StaffFactoryInterface;
use Staffer\Domain\ValueObjects\Staff;

/**
 * Class StaffFactory
 */
class StaffFactory implements StaffFactoryInterface
{
    const CSV_ITEM_COUNT = 6;

    // +1 for id
    const DB_ITEM_COUNT = 7;

    /**
     * {@inheritdoc}
     */
    public function make(
        string $firstName,
        string $lastName,
        string $email,
        string $phoneNumber1,
        string $phoneNumber2,
        string $comments
    ) : Staff {
        return (new Staff())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhoneNumber1($phoneNumber1)
            ->setPhoneNumber2($phoneNumber2)
            ->setComments($comments);
    }

    /**
     * {@inheritdoc}
     */
    public function makeFromCsvArray(array $csvData) : Staff
    {
        if (count($csvData) !== self::CSV_ITEM_COUNT) {
            throw new InvalidArgumentException('Bad CSV data column count.');
        }

        return $this->make(
            $csvData[0],
            $csvData[1],
            $csvData[2],
            $csvData[3],
            $csvData[4],
            $csvData[5]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function makeFromDbArray(array $dbRow) : Staff
    {
        if (count($dbRow) !== self::DB_ITEM_COUNT) {
            throw new InvalidArgumentException('Bad DB data column count.');
        }

        return $this->make(
            $dbRow['first_name'],
            $dbRow['last_name'],
            $dbRow['email'],
            $dbRow['phone_number_1'],
            $dbRow['phone_number_2'],
            $dbRow['comments']
        )->setId((int) $dbRow['id']);
    }
}
