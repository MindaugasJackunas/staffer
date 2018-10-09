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
 * Class RemoveCommand
 */
class RemoveCommand extends AbstractStaffCommand
{
    const NAME = 'staff:remove';

    const ID = 'id';

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
            new Argument(self::ID)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $staffId = (int) $input->getArgument(self::ID);
            $staff = $this->staffActions->findById($staffId);
            $this->staffActions->remove($staff);
            $output->writeLn("Staff with ID {$staffId} deleted.");
        } catch (Exception $exception) {
            $output->writeLn('Staff removal failed: ' . $exception->getMessage());
        }
    }
}
