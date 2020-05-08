<?php

namespace App\Domain\Model\Repository;

use App\Domain\Entity\Address;
use App\Domain\Model\Repository\DoctrineAwareInterface;
use App\Domain\Model\Repository\DoctrineAwareTrait;
use App\Domain\Model\Repository\Contract\AddressRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;


class AddressRepository implements AddressRepositoryInterface, DoctrineAwareInterface
{
    use DoctrineAwareTrait;

    /**
     * @inheritdoc
     */
    public function getAll(): ?array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
            ->from(Address::class, 'c');
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @inheritdoc
     */
    public function getById(string $id): ?Address
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
            ->from(Address::class, 'c')
            ->where('c.id = :id')
            ->setMaxResults(1);

        $qb->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @inheritdoc
     */
    public function getByEmail(string $email): ?Address
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
            ->from(Address::class, 'c')
            ->where('c.email = :email')
            ->setMaxResults(1);

        $qb->setParameter('email', $email);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @inheritdoc
     */
    public function getByCredentials(string $email, string $password): ?Address
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
            ->from(Address::class, 'c')
            ->where('c.email = :email')
            ->andWhere('c.password = :password')
            ->setMaxResults(1);

        $qb->setParameter('email', $email);
        $qb->setParameter('password', $password);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @inheritdoc
     */
    public function create(Address $account, $flush = true): ?Address
    {
        $this->getEntityManager()->persist($account);

        if ($flush) {
            $this->flush();
        }

        return $account;
    }

    /**
     * @inheritdoc
     */
    public function update(Address $account, $flush = true): ?Address
    {

        $account = $this->getEntityManager()->merge($account);

        if ($flush) {
            $this->flush();
        }

        return $account;
    }

    /**
     * @inheritdoc
     */
    public function remove(Address $account, $flush = true): bool
    {
        $this->getEntityManager()->remove($account);

        if ($flush) {
            $this->flush();
        }

        return true;
    }
}
