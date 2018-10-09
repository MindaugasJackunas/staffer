<?php

declare(strict_types = 1);

namespace Staffer\Validation;

use Staffer\Domain\ValueObjects\Staff;

/**
 * Class StaffValidator
 */
class StaffValidator
{
    const EMAIL_PATTERN = '/^.+\@\S+\.\S+$/';

    /**
     * @param Staff $staff
     *
     * @return bool
     */
    public function isValid(Staff $staff) : bool
    {
        return $this->isEmailValid($staff->getEmail());
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    public function isEmailValid(string $email) : bool
    {
        return preg_match(self::EMAIL_PATTERN, $email)
            ? true
            : false;
    }
}
