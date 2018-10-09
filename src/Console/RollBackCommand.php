<?php

declare(strict_types = 1);

namespace Staffer\Console;

use Exception;
use Staffer\Console\Abstractions\AbstractMigrationCommand;
use Staffer\Infrastructure\Console\Input\InputInterface;
use Staffer\Infrastructure\Console\Output\OutputInterface;

/**
 * Class RollBackCommand
 */
class RollBackCommand extends AbstractMigrationCommand
{
    const NAME = 'migrations:rollback';

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
            $this->stafferMigration->down();
        } catch (Exception $exception) {
            $output->writeLn('DB rollback error: ' . $exception->getMessage());
        }
    }
}
