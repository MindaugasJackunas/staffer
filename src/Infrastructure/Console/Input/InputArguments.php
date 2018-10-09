<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console\Input;

use InvalidArgumentException;

/**
 * Class InputArguments
 */
class InputArguments
{
    /**
     * @var string
     */
    private $commandName;

    /**
     * @var array
     */
    private $inputArguments;

    /**
     * InputArguments constructor.
     *
     * @param array $inputArguments
     */
    public function __construct(array $inputArguments)
    {
        /**
         * Remove console script name.
         */
        if (count($inputArguments) > 0) {
            array_shift($inputArguments);
        }

        if (count($inputArguments) === 0) {
            throw new InvalidArgumentException('Application requires command name as argument.');
        }

        $this->commandName = $inputArguments[0];
        array_shift($inputArguments);

        $this->inputArguments = $inputArguments;
    }

    /**
     * @return string
     */
    public function getCommandName() : string
    {
        return $this->commandName;
    }

    /**
     * @return array
     */
    public function getInputArguments() : array
    {
        return $this->inputArguments;
    }
}
