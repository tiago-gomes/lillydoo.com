<?php

namespace App\Domain\Tests\Unit\Repository;

use App\Domain\Entity\Address;
use App\Domain\Model\Repository\AddressRepository;
use App\Domain\Model\Repository\Contract\AddressRepositoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \Mockery;

class AccountTest extends WebTestCase
{

    /**
     * @return array
     */
    public function parametersProvider(){
        return [
            [
                [
                    'firstName'  => 'Smith',
                    'lastName'  => 'Jonas',
                    'email'  => 'info@smithJonas.com'
                ]
            ]
        ];
    }

    /**
     * @var \Mockery\MockInterface
     */
    private $repositoryMock;

    /**
     * @var ContainerInterface
     */
    private $testContainer;

    protected function setUp() {
        parent::setUp();
        $client = self::createClient();
        $this->testContainer = $client->getContainer();
        $this->testContainer->set(AddressRepositoryInterface::class, $this->repositoryMock);
        $this->repositoryMock = Mockery::mock(AddressRepository::class);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @dataProvider parametersProvider
     * @test
     */
    public function itShouldCreateAnewAccount($account)
    {

        $mockAccount = Mockery::mock(Address::class);

        $this->repositoryMock
            ->shouldReceive($this->once())
            ->withAnyArgs($account)
            ->andReturn($mockAccount);

        static::$kernel
            ->getContainer()
            ->get(AddressRepositoryInterface::class)->create(new Address($account));


    }
}
