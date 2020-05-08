<?php

namespace App\Domain\Service\Contract;

use Symfony\Component\HttpFoundation\Request;
use App\Domain\Entity\Account;

interface AuthServiceInterface
{
    /**
     * @param Request $request
     * @return null|string
     */
    public function authenticate(Request $request): ?string;

    /**
     * @param Request $request
     * @return Account|null
     */
    public function register(Request $request): ?Account;

    /**
     * @param Request $request
     * @return Account|null
     */
    public function recovery(Request $request): ?Account;
}