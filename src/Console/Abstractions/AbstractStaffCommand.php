<?php

declare(strict_types = 1);

namespace Staffer\Console\Abstractions;

use Staffer\Domain\Actions\StaffActions;
use Staffer\Infrastructure\Console\AbstractCommand;

/**
 * Class StaffCommand
 */
abstract class AbstractStaffCommand extends AbstractCommand
{
    /**
     * @var StaffActions
     */
    protected $staffActions;

    /**
     * StaffCommand constructor.
     *
     * @param StaffActions $staffActions
     */
    public function __construct(StaffActions $staffActions)
    {
        $this->staffActions = $staffActions;
    }
}
