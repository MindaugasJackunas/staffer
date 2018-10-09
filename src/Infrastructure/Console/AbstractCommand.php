<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console;

use Exception;
use Staffer\Infrastructure\Console\Input\Argument;
use Staffer\Infrastructure\Console\Input\Arguments;
use Staffer\Infrastructure\Console\Input\InputInterface;
use Staffer\Infrastructure\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 */
abstract class AbstractCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    abstract public static function getName() : string;

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return mixed
     */
    abstract public function execute(InputInterface $input, OutputInterface $output);

    /**
     * @return Arguments
     */
    public function getArguments() : Arguments
    {
        return new Arguments();
    }

    /**
     * @param InputInterface $input
     *
     * @throws Exception
     */
    public function processArguments(InputInterface $input)
    {
        $i = 0;
        /** @var Argument $argument */
        foreach ($this->getArguments() as $argument) {
            if (!isset($input->getInputArguments()->getInputArguments()[$i])) {
                throw new Exception("Required argument '{$argument->getName()}' not set.");
            }

            $input->setArgument($argument->getName(), $input->getInputArguments()->getInputArguments()[$i]);
            $i++;
        }
    }

    /**
     *
     */
    public function configure()
    {
        $this->name = $this->getName();
    }
}
