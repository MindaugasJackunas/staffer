<?php

declare(strict_types = 1);

namespace Staffer;

use Configuration\MySqlConfiguration;
use Staffer\Console\ListCommand;
use Staffer\Console\RemoveCommand;
use Staffer\Console\SearchCommand;
use Staffer\Domain\FactoryInterfaces\StaffFactoryInterface;
use Staffer\Domain\GeneratorInterfaces\StaffGeneratorInterface;
use Staffer\Domain\RepositoryInterfaces\StaffRepositoryInterface;
use Staffer\Infrastructure\Application\AbstractApplication;
use Staffer\Console\AddCommand;
use Staffer\Console\ImportCommand;
use Staffer\Infrastructure\Factories\StaffFactory;
use Staffer\Infrastructure\Generators\StaffGenerator;
use Staffer\Infrastructure\Persistence\ConfigurationInterface;
use Staffer\Infrastructure\Persistence\ConnectionInterface;
use Staffer\Console\MigrateCommand;
use Staffer\Console\RollBackCommand;
use Staffer\Infrastructure\Persistence\MySqlConnection;
use Staffer\Infrastructure\Repositories\StaffRepository;

/**
 * Class StafferApplication
 */
class StafferApplication extends AbstractApplication
{
    /**
     * {@inheritdoc}
     */
    public function getConsoleCommands() : array
    {
        return [
            AddCommand::NAME => AddCommand::class,
            ListCommand::NAME => ListCommand::class,
            ImportCommand::NAME => ImportCommand::class,
            RemoveCommand::NAME => RemoveCommand::class,
            SearchCommand::NAME => SearchCommand::class,
            MigrateCommand::NAME => MigrateCommand::class,
            RollBackCommand::NAME => RollBackCommand::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->container->set(StaffGeneratorInterface::class, StaffGenerator::class);
        $this->container->set(ConfigurationInterface::class, MySqlConfiguration::class);
        $this->container->set(ConnectionInterface::class, MySqlConnection::class);
        $this->container->set(StaffFactoryInterface::class, StaffFactory::class);
        $this->container->set(StaffRepositoryInterface::class, StaffRepository::class);
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
    }
}
