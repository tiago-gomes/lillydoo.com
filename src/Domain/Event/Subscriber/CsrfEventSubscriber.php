<?php

namespace App\Domain\Event\Subscriber;

use App\Core\Exceptions\AuthenticationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class CsrfEventSubscriber implements EventSubscriberInterface
{
    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        
        $response->headers->set('Access-Control-Allow-Origin' , '*', true);
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS, HEAD', true);

    
        return $response;
    }
    
    /**
    * @return array
    */
    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::RESPONSE => 'onKernelResponse'
        ];
    }
}