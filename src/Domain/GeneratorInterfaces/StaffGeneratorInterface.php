<?php

declare(strict_types = 1);

namespace Staffer\Domain\GeneratorInterfaces;

use Generator;
use Staffer\Domain\ValueObjects\Staff;

/**
 * Interface StaffGeneratorInterface
 */
interface StaffGeneratorInterface
{
    /**
     * @param string $fileName
     * @param bool $skipFirstLine
     *
     * @return Generator|Staff[]
     */
    public function getStaffFromCsvFile(string $fileName, bool $skipFirstLine) : Generator;
}
