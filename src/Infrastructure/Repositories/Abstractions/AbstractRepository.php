<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Repositories\Abstractions;

use Staffer\Infrastructure\Persistence\ConnectionInterface;

/**
 * Class AbstractRepository
 */
class AbstractRepository
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * AbstractRepository constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return ConnectionInterface
     */
    protected function getConnection() : ConnectionInterface
    {
        return $this->connection;
    }
}
