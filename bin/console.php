<?php

declare(strict_types = 1);

use Staffer\StafferApplication;

require __DIR__ . '/../vendor/autoload.php';

set_time_limit(0);

try {
    (new StafferApplication())->run($argv);
} catch (Exception $exception) {
    echo 'Error while running the application: ' . $exception->getMessage() . PHP_EOL;
}