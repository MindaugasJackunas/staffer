<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Persistence;

/**
 * Interface ConfigurationInterface
 */
interface ConfigurationInterface
{
    /**
     * @return string
     */
    public function getHost() : string;

    /**
     * @return string
     */
    public function getDatabase() : string;

    /**
     * @return string
     */
    public function getUsername() : string;

    /**
     * @return string
     */
    public function getPassword() : string;

    /**
     * @return string
     */
    public function getCharset() : string;

    /**
     * @return array
     */
    public function getOptions() : array;
}
