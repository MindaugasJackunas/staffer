<?php

declare(strict_types = 1);

namespace Staffer\Tests\Unit\Domain\Actions;

use Generator;
use Staffer\Domain\Actions\StaffActions;
use Staffer\Domain\FactoryInterfaces\StaffFactoryInterface;
use Staffer\Domain\GeneratorInterfaces\StaffGeneratorInterface;
use Staffer\Domain\RepositoryInterfaces\StaffRepositoryInterface;
use Staffer\Domain\ValueObjects\Staff;
use Staffer\Tests\Unit\StafferTestCase;

/**
 * Class StaffActionsTest
 */
class StaffActionsTest extends StafferTestCase
{
    /**
     * @return Generator
     */
    public function getRemoveTestData() : Generator
    {
        $staff = $this->getStaffMock();

        yield 'Normal scenario.' => [
            $staff,
            [
                'remove' => [
                    [
                        $this->once(),
                        [$staff],
                        null
                    ]
                ]
            ]
        ];
    }

    /**
     * @param Staff $staffToRemove
     * @param array $repositoryInvocations
     *
     * @dataProvider getRemoveTestData
     */
    public function testRemove(
        Staff $staffToRemove,
        array $repositoryInvocations
    ) {
        $this->setMock(StaffRepositoryInterface::class, $repositoryInvocations);

        /** @var StaffActions $staffActions */
        $staffActions = $this->get(StaffActions::class);

        $staffActions->remove($staffToRemove);
    }

    /**
     * @return Generator
     */
    public function getGetAllFromDbTestData() : Generator
    {
        yield 'Empty database.' => [
            [
                'getAll' => [
                    [
                        $this->once(),
                        [],
                        $this->returnCallback(function () {
                            yield from [];
                        })
                    ]
                ]
            ],
            [],
            []
        ];

        $staffData1 = [
            'id' => '1',
            'first_name' => 'first1',
            'last_name' => 'last1',
            'email' => 'email1',
            'phone_number_1' => 'phone1_1',
            'phone_number_2' => 'phone2_1',
            'comments' => 'comment1'
        ];

        $staffData2 = [
            'id' => '2',
            'first_name' => 'first2',
            'last_name' => 'last2',
            'email' => 'email2',
            'phone_number_1' => 'phone1_2',
            'phone_number_2' => 'phone2_2',
            'comments' => 'comment2'
        ];

        $staff1 = (new Staff())
            ->setId(1)
            ->setFirstName('first1')
            ->setLastName('last1')
            ->setEmail('email1')
            ->setPhoneNumber1('phone1_1')
            ->setPhoneNumber2('phone2_1')
            ->setComments('comment1');

        $staff2 = (new Staff())
            ->setId(2)
            ->setFirstName('first2')
            ->setLastName('last2')
            ->setEmail('email2')
            ->setPhoneNumber1('phone1_2')
            ->setPhoneNumber2('phone2_2')
            ->setComments('comment2');

        yield 'Two items in database.' => [
            [
                'getAll' => [
                    [
                        $this->once(),
                        [],
                        $this->returnCallback(function () use ($staffData1, $staffData2) {
                            yield from [$staffData1, $staffData2];
                        })
                    ]
                ]
            ],
            [
                'makeFromDbArray' => [
                    [
                        $this->at(0),
                        [$staffData1],
                        $this->returnValue($staff1)
                    ],
                    [
                        $this->at(1),
                        [$staffData2],
                        $this->returnValue($staff2)
                    ]
                ]
            ],
            [$staff1, $staff2]
        ];
    }

    /**
     * @param array $repositoryInvocations
     * @param array $factoryInvocations
     * @param array $expectedArray
     *
     * @dataProvider getGetAllFromDbTestData
     */
    public function testGetAllFromDb(
        array $repositoryInvocations,
        array $factoryInvocations,
        array $expectedArray
    ) {
        $this->setMock(StaffRepositoryInterface::class, $repositoryInvocations);
        $this->setMock(StaffFactoryInterface::class, $factoryInvocations);

        /** @var StaffActions $staffActions */
        $staffActions = $this->get(StaffActions::class);

        $actualGenerator = $staffActions->getAllFromDb();

        $this->assertEquals($expectedArray, iterator_to_array($actualGenerator));
    }

    /**
     * @return Generator
     */
    public function getGetAllFromCsvTestData() : Generator
    {
        $fileName = 'demoFile1.csv';
        $skipFirstLine = false;

        yield 'Empty file.' => [
            $fileName,
            $skipFirstLine,
            [
                'getStaffFromCsvFile' => [
                    [
                        $this->once(),
                        [$fileName, $skipFirstLine],
                        $this->returnCallback(function () {
                            yield from [];
                        })
                    ]
                ]
            ],
            [],
            []
        ];

        $fileName = 'folder/demoFile2.csv';
        $skipFirstLine = true;

        $staffData1 = [
            'first1',
            'last1',
            'email1',
            'phone1_1',
            'phone2_1',
            'comment1'
        ];

        $staffData2 = [
            'first2',
            'last2',
            'email2',
            'phone1_2',
            'phone2_2',
            'comment2'
        ];

        $staff1 = (new Staff())
            ->setFirstName('first1')
            ->setLastName('last1')
            ->setEmail('email1')
            ->setPhoneNumber1('phone1_1')
            ->setPhoneNumber2('phone2_1')
            ->setComments('comment1');

        $staff2 = (new Staff())
            ->setFirstName('first2')
            ->setLastName('last2')
            ->setEmail('email2')
            ->setPhoneNumber1('phone1_2')
            ->setPhoneNumber2('phone2_2')
            ->setComments('comment2');

        yield 'Two lines in CSV found.' => [
            $fileName,
            $skipFirstLine,
            [
                'getStaffFromCsvFile' => [
                    [
                        $this->once(),
                        [$fileName, $skipFirstLine],
                        $this->returnCallback(function () use ($staffData1, $staffData2) {
                            yield from [$staffData1, $staffData2];
                        })
                    ]
                ]
            ],
            [
                'makeFromCsvArray' => [
                    [
                        $this->at(0),
                        [$staffData1],
                        $this->returnValue($staff1)
                    ],
                    [
                        $this->at(1),
                        [$staffData2],
                        $this->returnValue($staff2)
                    ]
                ]
            ],
            [$staff1, $staff2]
        ];
    }

    /**
     * @param string $fileName
     * @param bool $skipFirstLine
     * @param array $generatorInvocations
     * @param array $factoryInvocations
     * @param array $expectedArray
     *
     * @dataProvider getGetAllFromCsvTestData
     */
    public function testGetAllFromCsv(
        string $fileName,
        bool $skipFirstLine,
        array $generatorInvocations,
        array $factoryInvocations,
        array $expectedArray
    ) {
        $this->setMock(StaffGeneratorInterface::class, $generatorInvocations);
        $this->setMock(StaffFactoryInterface::class, $factoryInvocations);

        /** @var StaffActions $staffActions */
        $staffActions = $this->get(StaffActions::class);

        $actualGenerator = $staffActions->getAllFromCsv($fileName, $skipFirstLine);

        $this->assertEquals($expectedArray, iterator_to_array($actualGenerator));
    }
}
