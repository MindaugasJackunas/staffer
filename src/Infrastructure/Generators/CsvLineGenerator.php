<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Generators;

use Generator;
use InvalidArgumentException;
use SplFileObject;

/**
 * Class CsvLineGenerator
 */
class CsvLineGenerator
{
    /**
     * @param string $fileName
     * @param bool $skipFirstLine
     *
     * @return Generator
     */
    public function getCsvLines(string $fileName, $skipFirstLine = false) : Generator
    {
        $this->assertFileExists($fileName);

        $file = new SplFileObject($fileName);
        $file->setFlags($this->getFlags());

        $lineNumber = 0;

        while (!$file->eof()) {
            $lineNumber++;

            if (!$this->skip($lineNumber, $skipFirstLine)) {
                yield $file->fgetcsv(";", "\"", "\\");
            }
        }
    }

    /**
     * @param int $lineNumber
     * @param bool $skipFirstLine
     *
     * @return bool
     */
    private function skip(int $lineNumber, bool $skipFirstLine) : bool
    {
        return $skipFirstLine && $lineNumber == 1;
    }

    /**
     * @param string $fileName
     */
    private function assertFileExists(string $fileName)
    {
        if (!file_exists($fileName)) {
            throw new InvalidArgumentException("File {$fileName} does not exists.");
        }
    }

    /**
     * @return int
     */
    private function getFlags() : int
    {
        return SplFileObject::READ_AHEAD
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::DROP_NEW_LINE
            | SplFileObject::READ_CSV;
    }
}
