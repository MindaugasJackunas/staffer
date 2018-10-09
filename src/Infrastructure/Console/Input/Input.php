<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console\Input;

/**
 * Class Input
 */
class Input implements InputInterface
{
    /**
     * @var InputArguments
     */
    private $inputArguments;

    /**
     * @var
     */
    private $arguments;

    /**
     * Input constructor.
     *
     * @param InputArguments $inputArguments
     */
    public function __construct(InputArguments $inputArguments)
    {
        $this->inputArguments = $inputArguments;
    }

    /**
     * {@inheritdoc}
     */
    public function getInputArguments() : InputArguments
    {
        return $this->inputArguments;
    }

    /**
     * {@inheritdoc}
     */
    public function getArgument(string $argumentName) : string
    {
        return $this->arguments[$argumentName];
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function setArgument(string $argumentName, string $argumentValue)
    {
        $this->arguments[$argumentName] = $argumentValue;
    }

    /**
     * {@inheritdoc}
     */
    public function readLn() : string
    {
        $handle = fopen('php://stdin', 'r');

        $line = fgets($handle);

        fclose($handle);

        return $line;
    }
}
