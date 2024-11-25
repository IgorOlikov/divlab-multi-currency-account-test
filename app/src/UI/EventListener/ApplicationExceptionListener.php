<?php

namespace App\UI\EventListener;

use App\Application\Exception\ApplicationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApplicationExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ApplicationException) {
            $response = new JsonResponse(['error' => $exception->getMessage()], $exception->getHttpErrorCode());

            $event->setResponse($response);
        }
    }
}