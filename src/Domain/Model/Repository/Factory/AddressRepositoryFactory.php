<?php

namespace App\Domain\Model\Repository\Factory;

use App\Core\Service\Contract\FactoryInterface;
use App\Domain\Model\Repository\AddressRepository;
use Psr\Container\ContainerInterface;

class AddressRepositoryFactory implements FactoryInterface
{
    /**
     * Account Repository
     *
     * @param ContainerInterface $container
     *
     * @return AddressRepository
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function service(ContainerInterface $container)
    {
        return (new AddressRepository())->setEntityManager($container->get('doctrine.orm.entity_manager'));
    }
}
