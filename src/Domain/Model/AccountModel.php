<?php

namespace App\Domain\Model;

use \Exception;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Entity\Account;
use App\Domain\Model\Repository\Contract\AccountRepositoryInterface;
use App\Domain\Model\Repository\Contract\CompanyRepositoryInterface;
use App\Domain\AbstractDomain;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 *
 * Todo: fix cache expiration time.
 *
 * Class AccountModel
 * @package App\Domain\Model
 */
class AccountModel extends AbstractDomain
{
    
    /**
     * @return array|null
     * @throws Exception
     */
    public function getAllAccounts(): ?array
    {
        try{
            return $this->container->get(AccountRepositoryInterface::class)->getAll();
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * @param int $id
     * @return Account
     * @throws Exception
     */
    public function getAccountById(int $id): Account
    {
        try{
            if (empty($id)) {
                throw new Exception('Account ID can not be empty');
            }
            if (!$account = $this->container->get(AccountRepositoryInterface::class)->getById($id)) {
                throw new \Exception('Account ID does not exist');
            }
            return $account;
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * @param $array
     * @return Account
     * @throws Exception
     */
    public function addAccount($array): Account
    {
        try{
            $account    = new Account($array);
            if ($accountExists = $this->container->get(AccountRepositoryInterface::class)->getByEmail($account->getEmail())) {
                throw new \Exception('An Account already exists with the provided email!');
            }
            $account->setCreatedAt(date('Y-m-d G:i:s'));
            $newAccount = $this->container->get(AccountRepositoryInterface::class)->create($account);
            $message = [
                'template'  =>'email/account/registration.html.twig',
                'data'      => $newAccount->toArray(),
                'subject'   => 'Account Registration'
            ];
            $newEmailMessage = json_encode($message);
            return $newAccount;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $id
     * @param $array
     * @return Account
     * @throws Exception
     */
    public function updateAccount(string $id, $array):  Account
    {
        try{
            if (!$account = $this->container->get(AccountRepositoryInterface::class)->getById($id)) {
                throw new Exception('Account not found!');
            }
            $account->populate($array);
            $account->setUpdatedAt(date('Y-m-d'));
            $this->container->get('cache.app')->deleteItem('getAllAccounts');
            return $this->container->get(AccountRepositoryInterface::class)->update($account);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function removeAccount(int $id): bool
    {
        try{
            $account = $this->container->get(AccountRepositoryInterface::class)->getById($id);
            $account->setDeletedAt(date('Y-m-d G:i:s'));
            return $this->container->get(AccountRepositoryInterface::class)->remove($account);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
