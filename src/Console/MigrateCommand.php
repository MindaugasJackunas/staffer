<?php

declare(strict_types = 1);

namespace Staffer\Console;

use Exception;
use Staffer\Console\Abstractions\AbstractMigrationCommand;
use Staffer\Infrastructure\Console\Input\InputInterface;
use Staffer\Infrastructure\Console\Output\OutputInterface;

/**
 * Class MigrateCommand
 */
class MigrateCommand extends AbstractMigrationCommand
{
    const NAME = 'migrations:migrate';

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
        try {
            $this->stafferMigration->up();
        } catch (Exception $exception) {
            $output->writeLn('DB schema migration error: ' . $exception->getMessage());
        }
    }
}
