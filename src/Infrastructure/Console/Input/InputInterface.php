<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console\Input;

/**
 * Interface InputInterface
 */
interface InputInterface
{
    /**
     * Returns actual input arguments.
     *
     * @return array
     */
    public function getArguments() : array;

    /**
     * @param string $argumentName
     *
     * @return string
     */
    public function getArgument(string $argumentName) : string;

    /**
     * @return InputArguments
     */
    public function getInputArguments() : InputArguments;

    /**
     * @param string $argumentName
     * @param string $argumentValue
     */
    public function setArgument(string $argumentName, string $argumentValue);

    /**
     * @return string
     */
    public function readLn() : string;
}
