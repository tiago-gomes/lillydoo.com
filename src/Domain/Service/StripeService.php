<?php

namespace App\Domain\Service;

use App\Domain\Service\Contract\StripeServiceInterface;
use App\Domain\AbstractDomain;
use Omnipay\Omnipay;
use App\Domain\Entity\CreditCard;
use App\Domain\Model\AccountModel;
use App\Domain\Model\InvoiceModel;
use App\Domain\Model\CompanyModel;
use App\Domain\Model\CustomerModel;

class StripeService extends AbstractDomain implements StripeServiceInterface
{

    const GATEWAY_NAME = 'Stripe';

    /**
     * @var AccountModel
     */
    protected $accountModel;

    /**
     * @var InvoiceModel
     */
    protected $invoiceModel;

    /**
     * @var CompanyModel
     */
    protected $companyModel;

    /**
     * @var CustomerModel
     */
    protected $customerModel;

    /**
     * StripeService constructor.
     * @param AccountModel $accountModel
     * @param InvoiceModel $invoiceModel
     * @param CompanyModel $companyModel
     * @param CustomerModel $customerModel
     */
    public function __construct(
        AccountModel $accountModel,
        InvoiceModel $invoiceModel,
        CompanyModel $companyModel,
        CustomerModel $customerModel
    )
    {
        $this->accountModel = $accountModel;
        $this->invoiceModel = $invoiceModel;
        $this->companyModel = $companyModel;
        $this->customerModel = $customerModel;
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function payWithCard($data): array
    {
        try{
            if (empty($array['token'])) {
                throw new \Exception('Stripe Token Field can not be empty');
            }
            if (empty($array['account_id'])) {
                throw new \Exception('Account ID Field can not be empty');
            }
            if (empty($array['invoice_id'])) {
                throw new \Exception('Invoice ID Field can not be empty');
            }
            if (empty($array['customer_id'])) {
                throw new \Exception('Customer ID Field can not be empty');
            }
            if (empty($array['company_id'])) {
                throw new \Exception('Company ID Field can not be empty');
            }
            if (empty($array['creditCardInformation'])) {
                throw new \Exception('Credit Card Details can not be empty');
            }

            $account = $this->accountModel->getAccountById($array['account_id']);
            $customer = $this->customerModel->getCustomerById($array['customer_id']);
            $invoice = $this->invoiceModel->getInvoiceById($array['invoice_id']);
            $company = $this->companyModel->getCompanyById($array['company_id']);

            $creditCardInformation = new CreditCard($array['creditCard']);

            $gateway = Omnipay::create(self::GATEWAY_NAME);
            $gateway->setApiKey($company->getStripeApiKey());

            $response = $gateway->purchase(
                [
                    'amount'    => $invoice->getAmount(),
                    'currency'  => $invoice->getCurrency(),
                    'card'      => $creditCardInformation->toArray(),
                    'source'    => $array['token']
                ]
            )->send();

            if ($response->isRedirect()) {
                return $response->redirect();
            } elseif ($response->isSuccessful()) {
                //$updatedInvoice = new Invoice($invoice->toArray());
                //$updatedInvoice->
                // save to database
                return $response;
            } else {
                // payment failed: display message to customer
                return  $response->getMessage();
            }

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $array
     * @return array
     * @throws \Exception
     */
    public function pay($array): array
    {
        try{

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $array
     * @return array|null
     * @throws \Exception
     */
    public function callback($array): ?array
    {
        try{

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
