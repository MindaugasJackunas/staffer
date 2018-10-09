<?php

declare(strict_types = 1);

namespace Staffer\Domain\ValueObjects;

/**
 * Class Staff
 */
class Staff
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phoneNumber1;

    /**
     * @var string
     */
    private $phoneNumber2;

    /**
     * @var string
     */
    private $comments;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Staff
     */
    public function setId(int $id) : Staff
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return Staff
     */
    public function setFirstName(string $firstName) : Staff
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName() : string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Staff
     */
    public function setLastName(string $lastName) : Staff
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Staff
     */
    public function setEmail(string $email) : Staff
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber1() : string
    {
        return $this->phoneNumber1;
    }

    /**
     * @param string $phoneNumber1
     *
     * @return Staff
     */
    public function setPhoneNumber1(string $phoneNumber1) : Staff
    {
        $this->phoneNumber1 = $phoneNumber1;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber2() : string
    {
        return $this->phoneNumber2;
    }

    /**
     * @param string $phoneNumber2
     *
     * @return Staff
     */
    public function setPhoneNumber2(string $phoneNumber2) : Staff
    {
        $this->phoneNumber2 = $phoneNumber2;

        return $this;
    }

    /**
     * @return string
     */
    public function getComments() : string
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     *
     * @return Staff
     */
    public function setComments(string $comments) : Staff
    {
        $this->comments = $comments;

        return $this;
    }
}
