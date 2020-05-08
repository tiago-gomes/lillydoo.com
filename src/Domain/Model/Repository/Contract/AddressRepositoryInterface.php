<?php

namespace App\Domain\Model\Repository\Contract;

use App\Domain\Entity\Address;
use phpDocumentor\Reflection\Types\Boolean;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;

interface AddressRepositoryInterface
{
    /**
     * @return Address|null
     */
    public function getAll(): ?array;

    /**
     * @param string $id
     * @return Address|null
     */
    public function getById(string $id): ?Address;

    /**
     * @param string $email
     * @return Address|null
     */
    public function getByEmail(string $email): ?Address;

    /**
     * @param string $email
     * @param string $password
     * @return Address|null
     */
    public function getByCredentials(string $email, string $password): ?Address;

    /**
     * @param Address $account
     * @return Address|null
     */
    public function create(Address $account, $flush = false): ?Address;

    /**
     * @param Address $account
     * @return Address|null
     */
    public function update(Address $account, $flush = false): ?Address;

    /**
     * @param bool $flush
     * @param Address $account
     * @return bool
     */
    public function remove(Address $account, $flush = false): bool;
}
