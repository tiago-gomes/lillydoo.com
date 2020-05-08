<?php

namespace App\Domain;

use Psr\Container\ContainerInterface;
use App\Domain\Model\Repository\Contract\AddressRepositoryInterface;
use App\Domain\Model\Repository\Contract\CompanyRepositoryInterface;

abstract class AbstractDomain
{
    /**
     * This is actually our Application
     *
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * todo: fix this
     * @return Entity\Address|null
     */
    public function getUser() {
        return $this->container->get(AddressRepositoryInterface::class)->getById(4);
    }

    /**
     * todo: fix this
     * @return Entity\Company|null
     */
    public function getUserCompany() {
        return $this->container->get(CompanyRepositoryInterface::class)->getById(4);
    }
}
