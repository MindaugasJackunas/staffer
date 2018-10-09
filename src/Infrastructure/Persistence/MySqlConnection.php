<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Persistence;

use Generator;
use PDO;
use PDOStatement;
use Staffer\Infrastructure\Persistence\Abstractions\AbstractConnection;

/**
 * Class MySqlConnection
 */
class MySqlConnection extends AbstractConnection implements ConnectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function query(string $sql) : Generator
    {
        foreach ($this->getDbHandle()->query($sql) as $row) {
            yield $row;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute(string $sql, array $parameters = []) : PDOStatement
    {
        $statement = $this->getDbHandle()->prepare($sql);

        $result = $statement->execute($parameters);

        if (!$result) {
            $pdoError = $statement->errorInfo();
            throw new MySqlException(
                "SQL code: {$pdoError[0]},"
                . " Driver code: {$pdoError[1]},"
                . " Error message: {$pdoError[2]}"
            );
        }

        return $statement;
    }

    /**
     * {@inheritdoc}
     */
    public function executeSelect(string $sql, array $parameters = []) : Generator
    {
        $statement = $this->execute($sql, $parameters);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            yield $row;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function executeSelectSingle(string $sql, array $parameters = [])
    {
        $statement = $this->execute($sql, $parameters);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritdoc}
     */
    public function getLastInsertId() : string
    {
        return $statement = $this->getDbHandle()->lastInsertId();
    }
}
