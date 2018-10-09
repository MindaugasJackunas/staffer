<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Container;

/**
 * Interface ContainerInterface
 */
interface ContainerInterface
{
    /**
     * @param string $abstract
     * @param null $concrete
     */
    public function set(string $abstract, $concrete = null);

    /**
     * @param string $abstract
     *
     * @return object
     */
    public function get(string $abstract);
}
