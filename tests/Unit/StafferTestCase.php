<?php

declare(strict_types = 1);

namespace Staffer\Tests\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Staffer\Domain\ValueObjects\Staff;
use Staffer\StafferApplication;

/**
 * Class StafferTestCase
 */
class StafferTestCase extends TestCase
{
    /**
     * @var StafferApplication
     */
    protected $application;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->application = new StafferApplication();
        $this->application->register();
    }

    /**
     * @param string $abstract
     *
     * @return object
     */
    protected function get(string $abstract)
    {
        return $this->application->getContainer()->get($abstract);
    }

    /**
     * @param string $abstract
     * @param null $concrete
     */
    protected function set(string $abstract, $concrete = null)
    {
        $this->application->getContainer()->set($abstract, $concrete);
    }

    /**
     * @param string $class
     * @param array $invocations
     */
    protected function setMock(string $class, array $invocations)
    {
        $this->set($class, $this->makeMock($class, $invocations));
    }

    /**
     * Creates custom mock for a specified class with specified invocations.
     *
     * @param string $class
     * @param array $mockInvocations
     *
     * @return MockObject
     */
    protected function makeMock(string $class, array $mockInvocations)
    {
        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        foreach ($mockInvocations as $methodName => $methodInvocations) {
            foreach ($methodInvocations as $invocation) {
                list($expectation, $with, $will) = $invocation;

                $invocationMocker = $mock->expects($expectation);
                $invocationMocker = $invocationMocker->method($methodName);
                $invocationMocker = $invocationMocker->with(...$with);

                if (!is_null($will)) {
                    $invocationMocker->will($will);
                }
            }
        }

        return $mock;
    }

    /**
     * @return Staff
     */
    protected function getStaffMock() : Staff
    {
        return (new Staff())
            ->setFirstName('testFirstName')
            ->setLastName('testLastName')
            ->setEmail('test@text.com')
            ->setPhoneNumber1('testPhone1')
            ->setPhoneNumber2('testPhone2')
            ->setComments('testCommand');
    }
}
