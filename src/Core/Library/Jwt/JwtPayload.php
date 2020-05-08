<?php

namespace App\Core\Library\Jwt;

use App\Domain\Entity\Address;
use Symfony\Component\HttpFoundation\File\File;

class JwtPayload
{
    /**
     * Unique identifier for token
     *
     * @var string
     */
    protected $jti;

    /**
     * Timestamp of token issuing.
     *
     * @var int
     */
    protected $iat;

    /**
     * Timestamp of when the token should start being considered valid.
     *
     * @var int
     */
    protected $nbf;

    /**
     * Timestamp of when the token should cease to be valid
     *
     * @var int
     */
    protected $exp;

    /**
     * Name or identifier of the issuer application.
     *
     * @var string
     */
    protected $iss;

    /**
     * @var Address
     */
    private $user;

    /**
     * @var File
     */
    protected $file;

    private const FILE_PRIVATE_KEY = '/keys/private';
    private const FILE_PUBLIC_KEY = '/keys/public';

    /**
     * JwtPayload constructor.
     * @param Address $account
     * @throws \Exception
     */
    public function __construct(Address $account)
    {
        $this->jti = base64_encode(random_bytes(32));
        $this->iat = time();
        $this->nbf = time() - 3600;
        $this->exp = time() + (3600 * 24 * 30);
        $this->iss = getenv('JWT_SERVER');
        $this->user = $account;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getPrivateKey()
    {
        try {
            return file_get_contents(  dirname(__FILE__) . self::FILE_PRIVATE_KEY);
        } catch( \Exception $e ) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getPublicKey()
    {
        try {
            return file_get_contents(dirname(__FILE__) . self::FILE_PUBLIC_KEY);
        } catch( \Exception $e ) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'iat' => $this->iat,
            'jti' => $this->jti,
            'iss' => $this->iss,
            'nbf' => $this->nbf,
            'exp' => $this->exp,
            'user' => $this->user->toArray()
        ];
    }
}