<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Generators;

use Generator;
use Staffer\Domain\GeneratorInterfaces\StaffGeneratorInterface;

/**
 * Class StaffGenerator
 */
class StaffGenerator implements StaffGeneratorInterface
{
    /**
     * @var CsvLineGenerator
     */
    private $csvLineGenerator;

    /**
     * StaffGenerator constructor.
     *
     * @param CsvLineGenerator $csvLineGenerator
     */
    public function __construct(
        CsvLineGenerator $csvLineGenerator
    ) {
        $this->csvLineGenerator = $csvLineGenerator;
    }

    /**
     * @param string $fileName
     * @param bool $skipFirstLine
     *
     * @return Generator
     */
    public function getStaffFromCsvFile(string $fileName, bool $skipFirstLine) : Generator
    {
        $lineNumber = 0;
        foreach ($this->csvLineGenerator->getCsvLines($fileName, $skipFirstLine) as $csvLine) {
            $lineNumber++;

            if ($skipFirstLine && $lineNumber === 1) {
                continue;
            }

            yield $csvLine;
        }
    }
}
