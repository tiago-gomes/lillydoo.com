<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06/09/2018
 * Time: 10:10
 */

namespace App\Core\Service\Contract;

use Psr\Container\ContainerInterface;

interface FactoryInterface
{
    public static function service(ContainerInterface $container);
}