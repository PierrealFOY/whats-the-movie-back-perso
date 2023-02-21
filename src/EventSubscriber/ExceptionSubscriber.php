<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();

        // check exception if i am on an api route
        $route = $request->get("_route");

        if (!strpos($route,"api")) {
            return;
        }

        $exception =$event->getThrowable();

        if ($exception instanceof HttpException) {
            $data = [
                'status' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ];

            $event->setResponse(new JsonResponse($data));

         }else{
            $data =[
                'status' => 500,
                'message' => $exception->getMessage()
            ];
    
            $event->setResponse(new JsonResponse($data));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
