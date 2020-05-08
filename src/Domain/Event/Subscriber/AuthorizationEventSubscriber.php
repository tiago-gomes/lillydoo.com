<?php

namespace App\Domain\Event\Subscriber;

use App\Core\Exceptions\AuthenticationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Core\Library\Jwt\JwtPayload;
use Firebase\JWT\JWT;

class AuthorizationEventSubscriber implements EventSubscriberInterface
{
  /**
   *
   * Allowed controllers do not need authorization token
   *
   * @var array $controllerException
   */
  private $controllerException = [
    'authenticate'
  ];
  
  /**
   * @param FilterControllerEvent $event
   * @throws AuthenticationException
   */
  public function onKernelController(FilterControllerEvent $event)
  {
    $token      = null;
    $controller = $event->getController();

    if (!is_array($controller)) {
      return;
    }
    
    if (in_array($controller[1], $this->controllerException)) {
        return;
    }
    
    /*
    if (empty($event->getRequest()->headers->get('authorization'))) {
      throw new AuthenticationException('An Autorization header is required.');
    }
  
    if (preg_match('/Bearer\s(\S+)/',  $event->getRequest()->headers->get('authorization'), $matches)) {
      $array = explode(" ", $event->getRequest()->headers->get('authorization'));
    }
    
    if(empty($array[1])) {
      throw new AuthenticationException('The token in the authorization header can not be empty', 401);
    }
    
    if ( !$payload = Jwt::decode($array[1], JwtPayload::getPublicKey(), ["RS256"]) ) {
      throw new AuthenticationException('The token is not valid', 401);
    }
    */
  }
  
  /**
   * @return array
   */
  public static function getSubscribedEvents()
  {
    return array(
      KernelEvents::CONTROLLER => 'onKernelController',
    );
  }
}