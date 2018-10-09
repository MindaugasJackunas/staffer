<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Persistence\Abstractions;

use PDO;
use PDOException;
use Staffer\Infrastructure\Persistence\ConfigurationInterface;
use Staffer\Infrastructure\Persistence\MySqlException;

/**
 * Class AbstractConnection
 */
abstract class AbstractConnection
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @var PDO
     */
    private $dbHandle;

    /**
     * MySqlConnection constructor.
     *
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Connects to database.
     */
    private function connect()
    {
        try {
            $this->dbHandle = new PDO(
                $this->getDsn(),
                $this->configuration->getUsername(),
                $this->configuration->getPassword(),
                $this->configuration->getOptions()
            );

            $this->dbHandle->query("use {$this->configuration->getDatabase()}");
        } catch (PDOException $e) {
            throw new MySqlException('MySQL connection failed: ' . $e->getMessage());
        }
    }

    /**
     * @return PDO
     */
    protected function getDbHandle() : PDO
    {
        if (is_null($this->dbHandle)) {
            $this->connect();
        }

        return $this->dbHandle;
    }

    /**
     * @return string
     */
    private function getDsn() : string
    {
        return "mysql:host={$this->configuration->getHost()};"
            . "dbname={$this->configuration->getDatabase()};"
            . "charset={$this->configuration->getCharset()}";
    }
}
