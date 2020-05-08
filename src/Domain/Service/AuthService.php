<?php

namespace App\Domain\Service;

use \Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Entity\Account;
use App\Domain\Model\Repository\Contract\AccountRepositoryInterface;
use App\Domain\Service\Contract\AuthServiceInterface;
use App\Domain\AbstractDomain;
use App\Core\Library\Jwt\JwtPayload;

class AuthService extends AbstractDomain implements AuthServiceInterface
{
    /**
     * @param Request $request
     * @return null|string
     * @throws \Exception
     */
    public function authenticate(Request $request): ?string
    {
        try{
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            if (empty($email)) {
                throw new \Exception('Invalid Email');
            }
            if (empty($password)) {
                throw new \Exception('Invalid Password');
            }
            $account = new Account($request->request->all());
            if (! $account = $this->container->get(AccountRepositoryInterface::class)->getByCredentials($account->getEmail(), $account->getPassword())) {
                throw new \Exception('Invalid Credentials');
            }
            $payload = new JwtPayload($account);
            return JWT::encode($payload->toArray(), $payload->getPrivateKey(), "RS256");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return Account|null
     * @throws \Exception
     */
    public function register(Request $request): ?Account
    {
        try{
            $email = $request->get('email');
            if (empty($email)) {
                throw new \Exception('Invalid Email');
            }
            $account = new Account($request->request->all());
            if ($accountExists = $this->container->get(AccountRepositoryInterface::class)->getByEmail($email)) {
                throw new \Exception('An Account already exists with the provided email!');
            }
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
     * @param Request $request
     * @return Account|null
     * @throws \Exception
     */
    public function recovery(Request $request): ?Account
    {
        try{
            $email = $request->get('email');
            if (empty($email)) {
                throw new \Exception('Field email can not be empty');
            }
            $emailAccount = $this->container->get(AccountRepositoryInterface::class)->getByEmail($email);
            if (empty($emailAccount)) {
                throw new \Exception('Invalid Email');
            }
            $account = new Account($request->request->all());
            $newPassword = substr(md5(uniqid(mt_rand())), 0, 13);
            $account->setPassword($newPassword);
            $updatedAccount = array_replace($emailAccount->toArray(), $account->toArray());
            $newAccount = $this->container->get(AccountRepositoryInterface::class)->update(new Account($updatedAccount));
            $message = [
                'template'  => 'email/account/recovery.html.twig',
                'data'      => $newAccount->toArray(),
                'subject'   => 'Account Recovery',
                'newPassword' => $newPassword
            ];
            $newEmailMessage = json_encode($message);
            return $newAccount;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
