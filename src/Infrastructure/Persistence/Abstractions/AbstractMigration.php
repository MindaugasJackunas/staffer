<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Persistence\Abstractions;

use Staffer\Infrastructure\Persistence\ConfigurationInterface;
use Staffer\Infrastructure\Persistence\ConnectionInterface;

/**
 * Class AbstractMigration
 */
abstract class AbstractMigration
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * AbstractMigration constructor.
     *
     * @param ConnectionInterface $connection
     * @param ConfigurationInterface $configuration
     */
    public function __construct(
        ConnectionInterface $connection,
        ConfigurationInterface $configuration
    ) {
        $this->connection = $connection;
        $this->configuration = $configuration;
    }

    /**
     * @return mixed
     */
    abstract public function up();

    /**
     * @return mixed
     */
    abstract public function down();

    /**
     * @return ConnectionInterface
     */
    protected function getConnection() : ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @return ConfigurationInterface
     */
    protected function getConfiguration() : ConfigurationInterface
    {
        return $this->configuration;
    }

    /**
     * Execute UP migration.
     */
    public function executeUp()
    {
        $this->up();
    }

    /**
     * Execute DOWN migration.
     */
    public function executeDown()
    {
        $this->down();
    }
}
