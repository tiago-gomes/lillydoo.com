<?php

namespace App\Core\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonException
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $message = [
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $exception->getMessage()
        ];

        $response = new JsonResponse($message);
        $response->headers->set('Content-Type', 'application/json');
        
        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
