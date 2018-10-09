<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console\Input;

/**
 * Class Argument
 */
class Argument
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var bool
     */
    private $required;

    /**
     * Argument constructor.
     *
     * @param string $name
     * @param bool $required
     */
    public function __construct(
        string $name,
        bool $required = true
    ) {
        $this->name = $name;
        $this->required = $required;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function isRequired() : bool
    {
        return $this->required;
    }
}
