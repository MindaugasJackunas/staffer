<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Migrations;

use Staffer\Infrastructure\Persistence\Abstractions\AbstractMigration;

/**
 * Class StafferMigration
 */
class StafferMigration extends AbstractMigration
{
    const TABLE_NAME = 'staff';

    /**
     * {@inheritdoc
     */
    public function up()
    {
        $sql = "
            CREATE TABLE `" . self::TABLE_NAME . "` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `first_name` VARCHAR(50) CHARACTER SET 'utf8mb4' NOT NULL,
                `last_name` VARCHAR(50) CHARACTER SET 'utf8mb4' NOT NULL,
                `email` VARCHAR(100) CHARACTER SET 'utf8mb4' NOT NULL,
                `phone_number_1` VARCHAR(100) CHARACTER SET 'utf8mb4' NULL,
                `phone_number_2` VARCHAR(100) CHARACTER SET 'utf8mb4' NULL,
                `comments` VARCHAR(255) CHARACTER SET 'utf8mb4' NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `email_UNIQUE` (`email` ASC))";

        $this->getConnection()->execute($sql);
    }

    /**
     * {@inheritdoc
     */
    public function down()
    {
        $sql = "DROP TABLE `" . self::TABLE_NAME . "`";

        $this->getConnection()->execute($sql);
    }
}
