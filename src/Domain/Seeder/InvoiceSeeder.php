<?php
namespace App\Domain\Seeder;

use App\Domain\Entity\Customer;
use App\Domain\Model\Repository\Contract\CustomerRepositoryInterface;
use App\Domain\Entity\Account;
use App\Domain\Model\Repository\Contract\AccountRepositoryInterface;
use App\Domain\Entity\Company;
use App\Domain\Model\Repository\Contract\CompanyRepositoryInterface;
use App\Domain\Entity\Invoice;
use App\Domain\Model\Repository\Contract\InvoiceRepositoryInterface;
use App\Domain\Entity\InvoiceLine;
use App\Domain\Model\Repository\Contract\InvoiceLineRepositoryInterface;
use Psr\Container\ContainerInterface;
use Faker;

/**
 * Class InvoiceSeeder
 * @package App\Domain\Seeder
 */
class InvoiceSeeder
{
  /**
   * @var ContainerInterface
   */
  protected $container;
  
  /**
   * InvoiceSeeder constructor.
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
      for($i=0;$i<=1;$i++) {
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
        $newCompany = $this->container->get(CompanyRepositoryInterface::class)->create($company);
        $customer = new Customer([
          'firstName' => $faker->name,
          'lastName' => $faker->lastName,
          'userName' => $faker->userName,
          'email' => $faker->email
        ]);
        $customer->setAccount($account);
        $newCustomer = $this->container->get(CustomerRepositoryInterface::class)->create($customer);
        for($k=0;$k<=1;$k++) {
          $invoice = new Invoice([
            'status' => 'pending'
          ]);
          $invoice->setAccount($newAccount);
          $invoice->setCompany($newCompany);
          $invoice->setCustomer($newCustomer);
          $newInvoice = $this->container->get(InvoiceRepositoryInterface::class)->create($invoice);
          for($j=0;$j<=1;$j++) {
            $invoiceLine = new InvoiceLine([
              'productName' => $faker->name,
              'price' => rand(5,25),
              'quantity' => rand(1,5),
              'description' => $faker->text(10),
              'vat' => rand(0,30)
            ]);
            $invoiceLine->setAccount($newAccount);
            $invoiceLine->setInvoice($newInvoice);
            $this->container->get(InvoiceLineRepositoryInterface::class)->create($invoiceLine);
          }
          $invoiceLines =  $this->container->get(InvoiceLineRepositoryInterface::class)->getLinesByInvoice($invoice);
          $calculations = InvoiceLine::calculateLines($invoiceLines);
          $newInvoice->setAmount($calculations['grandTotal']);
          $newInvoice->setStatus(Invoice::INVOICE_STATUS_COMPLETED);
          $newInvoice->setGateway(Invoice::GATEWAY_PAYPAL);
          $this->container->get(InvoiceRepositoryInterface::class)->update($newInvoice);
        }
      }
    } catch(\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
}