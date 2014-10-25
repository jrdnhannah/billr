<?php

namespace HCLabs\Bills\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onException', 200]
            ]
        ];
    }

    /**
     * @param GetResponseForExceptionEvent $e
     */
    public function onException(GetResponseForExceptionEvent $e)
    {
        $exception = $e->getException();
        if ($e->getRequest()->isXmlHttpRequest() && $exception instanceof HttpException) {
            $e->setResponse(
                new JsonResponse([
                        'status_code' => $exception->getStatusCode(),
                        'message'     => $exception->getMessage()
                    ]
                )
            );
        }
    }
}