<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Repositories;

use Exception;
use Generator;
use Staffer\Domain\Exceptions\StaffException;
use Staffer\Domain\RepositoryInterfaces\StaffRepositoryInterface;
use Staffer\Domain\ValueObjects\Staff;
use Staffer\Infrastructure\Persistence\ConnectionInterface;
use Staffer\Infrastructure\Repositories\Abstractions\AbstractRepository;
use Staffer\Validation\StaffValidator;

/**
 * Class StaffRepository
 */
class StaffRepository extends AbstractRepository implements StaffRepositoryInterface
{
    /**
     * @var StaffValidator
     */
    private $staffValidator;

    /**
     * StaffRepository constructor.
     *
     * @param ConnectionInterface $connection
     * @param StaffValidator $staffValidator
     */
    public function __construct(
        ConnectionInterface $connection,
        StaffValidator $staffValidator
    ) {
        parent::__construct($connection);

        $this->staffValidator = $staffValidator;
    }

    /**
     * @param Staff $staff
     *
     * @return int
     *
     * @throws StaffException
     */
    public function add(Staff $staff) : int
    {
        $this->assertValidEmail($staff);

        $sql = 'INSERT INTO `staff` (`first_name`, `last_name`, `email`, `phone_number_1`, `phone_number_2`, `comments`)
            VALUES (:first_name, :last_name, :email, :phone_number_1, :phone_number_2, :comments)';

        $parameters = [
            'first_name' => $staff->getFirstName(),
            'last_name' => $staff->getLastName(),
            'email' => $staff->getEmail(),
            'phone_number_1' => $staff->getPhoneNumber1(),
            'phone_number_2' => $staff->getPhoneNumber2(),
            'comments' => $staff->getComments()
        ];

        $this->getConnection()->execute($sql, $parameters);

        return (int) $this->getConnection()->getLastInsertId();
    }

    /**
     * @return Generator|array
     */
    public function getAll() : Generator
    {
        $sql = 'SELECT `id`, `first_name`, `last_name`, `email`, `phone_number_1`, `phone_number_2`, `comments`
            FROM `staff`';

        foreach ($this->getConnection()->executeSelect($sql) as $row) {
            yield $row;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $staffId) : array
    {
        $sql = 'SELECT `id`, `first_name`, `last_name`, `email`, `phone_number_1`, `phone_number_2`, `comments`
            FROM `staff`
            WHERE `id` = :id';

        $parameters = ['id' => $staffId];

        $row = $this->getConnection()->executeSelectSingle($sql, $parameters);

        if (!$row) {
            throw new Exception("Staff with ID: {$staffId} does not exists.");
        }

        return $row;
    }

    /**
     * {@inheritdoc}
     */
    public function findByText(string $searchText)
    {
        // TODO: Implement findByText() method.
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Staff $staff)
    {
        $sql = 'DELETE
            FROM `staff`
            WHERE `id` = :id';

        $parameters = ['id' => $staff->getId()];

        $this->getConnection()->executeSelectSingle($sql, $parameters);
    }

    /**
     * @param Staff $staff
     *
     * @throws StaffException
     */
    private function assertValidEmail(Staff $staff)
    {
        if (!$this->staffValidator->isEmailValid($staff->getEmail())) {
            throw new StaffException('Not valid email.');
        }
    }
}
