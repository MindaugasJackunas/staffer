<?php

declare(strict_types = 1);

namespace Staffer\Console;

use Staffer\Console\Abstractions\AbstractStaffCommand;
use Staffer\Infrastructure\Console\Input\InputInterface;
use Staffer\Infrastructure\Console\Output\OutputInterface;

/**
 * Class SearchCommand
 */
class SearchCommand extends AbstractStaffCommand
{
    const NAME = 'staff:search';

    /**
     * {@inheritdoc}
     */
    public static function getName() : string
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeLn('Not implemented.');
    }
}
