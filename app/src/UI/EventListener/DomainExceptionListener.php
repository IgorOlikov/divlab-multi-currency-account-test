<?php

namespace App\UI\EventListener;


use App\Domain\Exception\DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class DomainExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof DomainException) {
            $response = new JsonResponse(['error' => $exception->getMessage()], $exception->getHttpErrorCode());

            $event->setResponse($response);
        }
    }
}