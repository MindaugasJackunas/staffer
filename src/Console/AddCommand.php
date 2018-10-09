<?php

declare(strict_types = 1);

namespace Staffer\Console;

use Exception;
use Staffer\Console\Abstractions\AbstractStaffCommand;
use Staffer\Domain\Actions\StaffActions;
use Staffer\Domain\FactoryInterfaces\StaffFactoryInterface;
use Staffer\Infrastructure\Console\Input\InputInterface;
use Staffer\Infrastructure\Console\Input\Question;
use Staffer\Infrastructure\Console\Output\OutputInterface;

/**
 * Class AddCommand
 */
class AddCommand extends AbstractStaffCommand
{
    const NAME = 'staff:add';

    /**
     * @var Question
     */
    private $question;

    /**
     * @var StaffFactoryInterface
     */
    private $staffFactory;

    /**
     * AddCommand constructor.
     *
     * @param StaffActions $staffActions
     * @param Question $question
     * @param StaffFactoryInterface $staffFactory
     */
    public function __construct(
        StaffActions $staffActions,
        Question $question,
        StaffFactoryInterface $staffFactory
    ) {
        parent::__construct($staffActions);

        $this->question = $question;
        $this->staffFactory = $staffFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getName() : string
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln('Please enter new staff data:');

            $firstName = $this->question->ask($input, $output, 'First name:');
            $lastName = $this->question->ask($input, $output, 'Last name:');
            $email = $this->question->ask($input, $output, 'Email:');
            $phoneNumber1 = $this->question->ask($input, $output, 'Phone number 1:');
            $phoneNumber2 = $this->question->ask($input, $output, 'Phone number 2:');
            $comment = $this->question->ask($input, $output, 'Comment:');

            $staff = $this->staffFactory->make(
                $firstName,
                $lastName,
                $email,
                $phoneNumber1,
                $phoneNumber2,
                $comment
            );

            $staffId = $this->staffActions->add($staff);

            $output->writeln("Staff record added with ID: {$staffId}.");
        } catch (Exception $exception) {
            $output->writeLn('Error during staff creation: ' . $exception->getMessage());
        }
    }
}
