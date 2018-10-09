# Staff register - STAFFER #

Simple database driven staff register with console interface.

[Full task description (full_test_assignment_-_any_framework.docx, 18kb)](docs/full_test_assignment_-_any_framework.docx)

Extra requirement: do not use any external package except for PHPUnit.

## Application equirements ##

* Composer
* PHP 7.0+
* MySQL server 5.6+
* Git (optional)

## Installation

1. Clone/download code repository

2. Install dependencies:

    ```
    composer install
    ```

3. Edit file "config/MySqlConfiguration.php" and enter valid MySQL database details

4. Run database schema migrations:

    ```
    php bin/console.php migrations:migrate
    ```
5. Rollback database migrations:

    ```
    php bin/console.php migrations:rollback
    ```

## Usage

### See list of all possible commands:

```
php bin/console.php
```

### Import from CSV file

```
php bin/console.php staff:import <file>
```

### Import from provided demo file

```
php bin/console staffer:import assets/demo.csv
```

### List all records in database

```
php bin/console.php staff:list
```

### Interactive record insertion

```
php bin/console.php staff:add
```

### Record removal

```
php bin/console.php staff:remove <id>
```

### Search - NOT IMPLEMENTED

## Testing ##

```
php vendor/bin/phpunit -c build/phpunit.xml tests
```

## CodeSniffer

```
php vendor/bin/phpcs --standard=build/phpcs.xml -s src tests
```

## Standards ##

* PSR-1, PSR-2, PSR-4, ~PSR-11, DDD
