<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Application;

use Exception;
use InvalidArgumentException;
use ReflectionException;
use Staffer\Infrastructure\Console\AbstractCommand;
use Staffer\Infrastructure\Console\Input\Input;
use Staffer\Infrastructure\Console\Input\InputArguments;
use Staffer\Infrastructure\Console\Input\InputInterface;
use Staffer\Infrastructure\Console\Output\Output;
use Staffer\Infrastructure\Console\Output\OutputInterface;
use Staffer\Infrastructure\Container\Container;
use Staffer\Infrastructure\Container\ContainerInterface;

/**
 * Class AbstractApplication
 */
abstract class AbstractApplication
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * StafferApplication constructor.
     */
    public function __construct()
    {
        $this->container = new Container();
    }

    /**
     * Register application dependencies.
     *
     * @return mixed
     */
    abstract protected function register();

    /**
     * Boot the application.
     *
     * @return mixed
     */
    abstract protected function boot();

    /**
     * @return array
     */
    abstract protected function getConsoleCommands() : array;

    /**
     * @return ContainerInterface
     */
    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param array $arguments
     *
     * @throws ReflectionException
     */
    public function run(array $arguments)
    {
        $this->initOutput();

        $this->register();

        $this->setupConsoleCommands();

        $this->boot();

        try {
            $inputArguments = new InputArguments($arguments);
        } catch (Exception $exception) {
            $this->printError($exception->getMessage());
            $this->printHelpAndExit();
        }

        $this->initInput($inputArguments);

        if (!$this->isConsoleCommandSupported($inputArguments->getCommandName())) {
            $this->printError('specified command is not supported');
            $this->printHelpAndExit();
        }

        $commandClass = $this->getConsoleCommandClass($inputArguments->getCommandName());

        /** @var AbstractCommand $command */
        $command = $this->container->get($commandClass);

        try {
            $command->processArguments($this->input);
            $command->execute($this->input, $this->output);
        } catch (Exception $exception) {
            $this->printError($exception->getMessage());
            $this->printHelpAndExit();
        }
    }

    /**
     * Binds console command into container.
     */
    private function setupConsoleCommands()
    {
        foreach ($this->getConsoleCommands() as $consoleCommandClass) {
            $this->container->set($consoleCommandClass);
        }
    }

    /**
     * Initialize input.
     */
    private function initInput(InputArguments $inputArguments)
    {
        $this->input = new Input($inputArguments);
        $this->container->set(InputInterface::class, $this->input);
    }

    /**
     * Initialize output.
     */
    private function initOutput()
    {
        $this->output = new Output();
        $this->container->set(OutputInterface::class, $this->output);
    }

    /**
     * @param string $commandName
     *
     * @return string
     */
    private function getConsoleCommandClass(string $commandName) : string
    {
        if (!$this->isConsoleCommandSupported($commandName)) {
            throw new InvalidArgumentException("Console command '{$commandName}' is not supported.");
        }

        return $this->getConsoleCommands()[$commandName];
    }

    /**
     * @param string $commandName
     *
     * @return bool
     */
    private function isConsoleCommandSupported(string $commandName) : bool
    {
        return isset($this->getConsoleCommands()[$commandName]);
    }

    /**
     * Prints help, available commands and terminates the application.
     *
     * @param int $exitCode
     */
    private function printHelpAndExit(int $exitCode = 0)
    {
        $this->printSyntax();
        $this->printAvailableCommands();

        exit($exitCode);
    }

    /**
     * Prints available commands.
     */
    private function printAvailableCommands()
    {
        $this->output->writeLn('Available commands:');

        foreach ($this->getConsoleCommands() as $commandName => $commandClass) {
            $this->output->writeLn("\t{$commandName}");
        }
    }

    /**
     * @param string $errorMessage
     */
    private function printError(string $errorMessage)
    {
        $this->output->writeLn('Error: ' . $errorMessage);
    }

    /**
     * Prints command syntax.
     */
    private function printSyntax()
    {
        $this->output->writeLn("\tSyntax: php bin/console.php <command_name> [<command_arguments>]");
    }
}
