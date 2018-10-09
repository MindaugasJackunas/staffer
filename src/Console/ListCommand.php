<?php

declare(strict_types = 1);

namespace Staffer\Console;

use Staffer\Console\Abstractions\AbstractStaffCommand;
use Staffer\Domain\ValueObjects\Staff;
use Staffer\Infrastructure\Console\Input\InputInterface;
use Staffer\Infrastructure\Console\Output\OutputInterface;

/**
 * Class ListCommand
 */
class ListCommand extends AbstractStaffCommand
{
    const NAME = 'staff:list';

    const COLUMN_SEPARATOR = ' | ';

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
    public function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->staffActions->getAllFromDb() as $staff) {
            $output->writeLn($this->glueFields($staff));
        }
    }

    /**
     * @param Staff $staff
     *
     * @return string
     */
    private function glueFields(Staff $staff) : string
    {
        return join(
            self::COLUMN_SEPARATOR,
            [
                $staff->getId(),
                $staff->getFirstName(),
                $staff->getLastName(),
                $staff->getEmail()
            ]
        );
    }
}
