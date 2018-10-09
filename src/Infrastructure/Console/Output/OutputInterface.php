<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Console\Output;

/**
 * Interface OutputInterface
 */
interface OutputInterface
{
    /**
     * @param string $text
     *
     * @return mixed
     */
    public function write(string $text);

    /**
     * @param string $text
     *
     * @return mixed
     */
    public function writeLn(string $text);
}
