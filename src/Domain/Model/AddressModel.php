<?php

namespace App\Domain\Model;

use \Exception;
use App\Domain\Entity\Address;
use App\Domain\Model\Repository\Contract\AddressRepositoryInterface;
use App\Domain\AbstractDomain;


/**
 *

 *
 * Class AddressModel
 * @package App\Domain\Model
 */
class AddressModel extends AbstractDomain
{
    
    /**
     * @return array|null
     * @throws Exception
     */
    public function getAllAddresss(): ?array
    {
        try{
            return $this->container->get(AddressRepositoryInterface::class)->getAll();
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * @param int $id
     * @return Address
     * @throws Exception
     */
    public function getAddressById(int $id): Address
    {
        try{
            if (empty($id)) {
                throw new Exception('Address ID can not be empty');
            }
            if (!$address = $this->container->get(AddressRepositoryInterface::class)->getById($id)) {
                throw new \Exception('Address ID does not exist');
            }
            return $address;
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * @param $array
     * @return Address
     * @throws Exception
     */
    public function addAddress($array): Address
    {
        try{
            $address    = new Address($array);
            if ($addressExists = $this->container->get(AddressRepositoryInterface::class)->getByEmail($address->getEmail())) {
                throw new \Exception('An Address already exists with the provided email!');
            }
            $address->setCreatedAt(date('Y-m-d G:i:s'));
            return $this->container->get(AddressRepositoryInterface::class)->create($address);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $id
     * @param $array
     * @return Address
     * @throws Exception
     */
    public function updateAddress(string $id, $array):  Address
    {
        try{
            if (!$address = $this->container->get(AddressRepositoryInterface::class)->getById($id)) {
                throw new Exception('Address not found!');
            }
            $address->populate($array);
            $address->setUpdatedAt(date('Y-m-d'));
            return $this->container->get(AddressRepositoryInterface::class)->update($address);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function removeAddress(int $id): bool
    {
        try{
            $address = $this->container->get(AddressRepositoryInterface::class)->getById($id);
            $address->setDeletedAt(date('Y-m-d G:i:s'));
            return $this->container->get(AddressRepositoryInterface::class)->remove($address);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
