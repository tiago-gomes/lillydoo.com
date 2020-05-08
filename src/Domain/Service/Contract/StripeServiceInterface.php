<?php

namespace App\Domain\Service\Contract;

use Symfony\Component\HttpFoundation\Request;
use App\Domain\Entity\Account;

interface StripeServiceInterface
{
    /**
     * @param array $array
     * @return array
     */
    public function pay($array): array;

    /**
     * @param $data
     * @return array
     */
    public function payWithCard($data): array;

    /**
     * @param $array
     * @return array|null
     */
    public function callback($array): ?array;
}