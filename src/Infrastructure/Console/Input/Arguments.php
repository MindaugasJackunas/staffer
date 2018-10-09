<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console\Input;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * Class Arguments
 */
class Arguments implements IteratorAggregate
{
    /**
     * @var Argument[]
     */
    private $arguments;

    /**
     * Arguments constructor.
     *
     * @param Argument ...$arguments
     */
    public function __construct(Argument ...$arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->arguments);
    }
}
