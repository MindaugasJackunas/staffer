<?php

declare(strict_types = 1);

namespace Configuration;

use Staffer\Infrastructure\Persistence\ConfigurationInterface;

/**
 * Class MySqlConfiguration
 */
class MySqlConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getHost() : string
    {
        return '192.168.1.100';
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase() : string
    {
        return 'staffer';
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername() : string
    {
        return 'dbusername';
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword() : string
    {
        return 'dbpassword';
    }

    /**
     * {@inheritdoc}
     */
    public function getPost() : string
    {
        return '3306';
    }

    /**
     * {@inheritdoc}
     */
    public function getCharset(): string
    {
        return 'utf8mb4';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions() : array
    {
        return [];
    }
}
