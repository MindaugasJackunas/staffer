<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console\Output;

/**
 * Class Output
 */
class Output implements OutputInterface
{
    /**
     * {@inheritdoc}
     */
    public function write(string $text)
    {
        echo $text;
    }

    /**
     * {@inheritdoc}
     */
    public function writeLn(string $text)
    {
        $this->write($text);
        $this->write(PHP_EOL);
    }
}
