<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Persistence;

use Generator;
use PDOStatement;

/**
 * Interface ConnectionInterface
 */
interface ConnectionInterface
{
    /**
     * @param string $sql
     *
     * @return Generator
     */
    public function query(string $sql) : Generator;

    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return PDOStatement
     */
    public function execute(string $sql, array $parameters = []) : PDOStatement;

    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return Generator
     */
    public function executeSelect(string $sql, array $parameters = []) : Generator;

    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return mixed
     */
    public function executeSelectSingle(string $sql, array $parameters = []);

    /**
     * @return string
     */
    public function getLastInsertId() : string;
}
