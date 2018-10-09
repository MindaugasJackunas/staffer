<?php

declare(strict_types = 1);

namespace Staffer\Console;

use Exception;
use Staffer\Console\Abstractions\AbstractStaffCommand;
use Staffer\Infrastructure\Console\Input\Argument;
use Staffer\Infrastructure\Console\Input\Arguments;
use Staffer\Infrastructure\Console\Input\InputInterface;
use Staffer\Infrastructure\Console\Output\OutputInterface;

/**
 * Class ImportCommand
 */
class ImportCommand extends AbstractStaffCommand
{
    const NAME = 'staff:import';

    const FILE_NAME = 'fileName';

    // TODO
    const CONTINUE_ON_ERROR = '--continue-on-error';

    // TODO
    const SKIP_FIRST_LINE = '--skip-first-line';

    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments() : Arguments
    {
        return new Arguments(
            new Argument(self::FILE_NAME)
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return mixed|void
     *
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument(self::FILE_NAME);
        $skipFirstLine = false;
        $continueOnError = true;

        $output->writeLn("Started staff import from file (will continue on errors): '{$fileName}'");

        $lineNumber = 0;
        foreach ($this->staffActions->getAllFromCsv($fileName, $skipFirstLine) as $staff) {
            $lineNumber++;
            try {
                $staffId = $this->staffActions->add($staff);
            } catch (Exception $exception) {
                $this->handleError($exception, $lineNumber, $continueOnError, $output);
            }
        }

        $output->writeLn("Import finished.");
    }

    /**
     * @param Exception $exception
     * @param int $lineNumber
     * @param bool $continueOnError
     * @param OutputInterface $output
     *
     * @throws Exception
     */
    private function handleError(
        Exception $exception,
        int $lineNumber,
        bool $continueOnError,
        OutputInterface $output
    ) {
        $errorMessage = "Error on line {$lineNumber}: {$exception->getMessage()}";

        if ($continueOnError) {
            $output->writeLn($errorMessage);
        } else {
            throw new Exception($errorMessage);
        }
    }
}
