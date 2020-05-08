<?php
namespace App\Domain\Seeder;

use App\Domain\Entity\Account;
use App\Domain\Model\Repository\Contract\AccountRepositoryInterface;
use App\Domain\Entity\Company;
use App\Domain\Model\Repository\Contract\CompanyRepositoryInterface;
use Psr\Container\ContainerInterface;
use Faker;

/**
 * Class AccountSeeder
 * @package App\Domain\Seeder
 */
class AccountSeeder
{
  /**
   * @var ContainerInterface
   */
  protected $container;
  
  /**
   * AccountSeeder constructor.
   * @param ContainerInterface $container
   * @throws \Exception
   */
  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
    $this->seed();
  }
  
  /**
   * @throws \Exception
   */
  protected function seed() {
    try{
      $faker = Faker\Factory::create();
      for($i=0;$i<=25;$i++) {
        $account = new Account([
          'firstName' => $faker->name,
          'lastName' => $faker->lastName,
          'userName' => $faker->userName,
          'email' => $faker->email,
          'password' => $faker->password,
          'salt' => $faker->randomNumber(4),
          'role' => 'user'
        ]);
        $newAccount = $this->container->get(AccountRepositoryInterface::class)->create($account);
        $company = new Company([
          'name' => $faker->domainName,
          'email' => $faker->email,
          'streetLine1' => $faker->streetName,
          'streetLine2' => $faker->streetAddress,
          'zipCode' => $faker->randomNumber(4),
          'country' => 125,
          'city' => $faker->city
        ]);
        $company->setAccount($newAccount);
        $this->container->get(CompanyRepositoryInterface::class)->create($company);
      }
    } catch(\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
}