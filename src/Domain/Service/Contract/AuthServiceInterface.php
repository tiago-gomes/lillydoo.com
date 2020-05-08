<?php

namespace App\Domain\Service\Contract;

use Symfony\Component\HttpFoundation\Request;
use App\Domain\Entity\Address;

interface AuthServiceInterface
{
    /**
     * @param Request $request
     * @return null|string
     */
    public function authenticate(Request $request): ?string;

    /**
     * @param Request $request
     * @return Address|null
     */
    public function register(Request $request): ?Address;

    /**
     * @param Request $request
     * @return Address|null
     */
    public function recovery(Request $request): ?Address;
}