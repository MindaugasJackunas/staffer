<?php

declare(strict_types = 1);

namespace Staffer\Console\Abstractions;

use Staffer\Infrastructure\Console\AbstractCommand;
use Staffer\Infrastructure\Migrations\StafferMigration;

/**
 * Class AbstractMigrationCommand
 */
abstract class AbstractMigrationCommand extends AbstractCommand
{
    /**
     * @var StafferMigration
     */
    protected $stafferMigration;

    /**
     * MigrateCommand constructor.
     *
     * @param StafferMigration $stafferMigration
     */
    public function __construct(StafferMigration $stafferMigration)
    {
        $this->stafferMigration = $stafferMigration;
    }
}
