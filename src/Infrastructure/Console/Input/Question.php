<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console\Input;

use Staffer\Infrastructure\Console\Output\OutputInterface;

/**
 * Class Question
 */
class Question
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param string $question
     * @return string
     */
    public function ask(
        InputInterface $input,
        OutputInterface $output,
        string $question
    ) : string {
        $output->write("\t" . $question . ' ');

        return trim($input->readLn());
    }
}
