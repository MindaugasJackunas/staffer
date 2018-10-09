<?php

declare(strict_types = 1);

namespace Staffer\Domain\Actions;

use Exception;
use Generator;
use Staffer\Domain\Exceptions\StaffException;
use Staffer\Domain\FactoryInterfaces\StaffFactoryInterface;
use Staffer\Domain\GeneratorInterfaces\StaffGeneratorInterface;
use Staffer\Domain\RepositoryInterfaces\StaffRepositoryInterface;
use Staffer\Domain\ValueObjects\Staff;
use Staffer\Validation\StaffValidator;

/**
 * Class StaffActions
 */
class StaffActions
{
    /**
     * @var StaffRepositoryInterface
     */
    private $staffRepository;

    /**
     * @var StaffGeneratorInterface
     */
    private $staffGenerator;

    /**
     * @var StaffFactoryInterface
     */
    private $staffFactory;

    /**
     * @var StaffValidator
     */
    private $staffValidator;

    /**
     * StaffActions constructor.
     *
     * @param StaffRepositoryInterface $staffRepository
     * @param StaffGeneratorInterface $staffGenerator
     * @param StaffFactoryInterface $staffFactory
     * @param StaffValidator $staffValidator
     */
    public function __construct(
        StaffRepositoryInterface $staffRepository,
        StaffGeneratorInterface $staffGenerator,
        StaffFactoryInterface $staffFactory,
        StaffValidator $staffValidator
    ) {
        $this->staffRepository = $staffRepository;
        $this->staffGenerator = $staffGenerator;
        $this->staffFactory = $staffFactory;
        $this->staffValidator = $staffValidator;
    }

    /**
     * @param Staff $staff
     */
    public function remove(Staff $staff)
    {
        $this->staffRepository->remove($staff);
    }

    /**
     * @return Generator|Staff[]
     */
    public function getAllFromDb() : Generator
    {
        foreach ($this->staffRepository->getAll() as $staff) {
            yield $this->staffFactory->makeFromDbArray($staff);
        }
    }

    /**
     * @param string $fileName
     * @param bool $skipFirstLine
     *
     * @return Generator|Staff[]
     */
    public function getAllFromCsv(string $fileName, bool $skipFirstLine) : Generator
    {
        foreach ($this->staffGenerator->getStaffFromCsvFile($fileName, $skipFirstLine) as $staff) {
            yield $this->staffFactory->makeFromCsvArray($staff);
        }
    }

    /**
     * @param int $staffId
     *
     * @return Staff
     *
     * @throws StaffException
     */
    public function findById(int $staffId) : Staff
    {
        try {
            $staffData = $this->staffRepository->findById($staffId);
        } catch (Exception $exception) {
            throw new StaffException("Staff record with ID {$staffId} does not exists.");
        }

        return $this->staffFactory->makeFromDbArray($staffData);
    }

    /**
     * @param Staff $staff
     *
     * @return int
     */
    public function add(Staff $staff) : int
    {
        return $this->staffRepository->add($staff);
    }
}
