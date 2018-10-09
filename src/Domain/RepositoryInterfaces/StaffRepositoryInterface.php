<?php

declare(strict_types = 1);

namespace Staffer\Domain\RepositoryInterfaces;

use Generator;
use Staffer\Domain\ValueObjects\Staff;

/**
 * Interface StaffRepositoryInterface
 */
interface StaffRepositoryInterface
{
    /**
     * @param Staff $staff
     *
     * @return int Last insert ID.
     */
    public function add(Staff $staff) : int;

    /**
     * @return Generator|array
     */
    public function getAll() : Generator;

    /**
     * @param Staff $staff
     *
     * @return mixed
     */
    public function remove(Staff $staff);

    /**
     * @param int $staffId
     *
     * @return array
     */
    public function findById(int $staffId) : array;

    /**
     * @param string $searchText
     *
     * @return mixed
     */
    public function findByText(string $searchText);
}
