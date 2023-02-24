<?php

namespace App\EventSubscriber;

use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use TypeError;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * method which when an exception on the api routes is thrown translates it into json
     *
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();

        // check exception if i am on an api route
        $route = $request->get("_route");

        if (!strpos($route,"api")) {
            return;
        }

        // I catch the exception
        $exception =$event->getThrowable();


        // If is an http exception i catch status ans error message
        if ($exception instanceof HttpException) {
            $data = [
                'status' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ];

            // I replace the exception with data in json format
            $event->setResponse(new JsonResponse($data));

        }elseif ($exception instanceof TypeError) {
            $message = explode("\\", $exception->getMessage());
            $entity = explode(" ", $message[4]);
            $data = [
                'status' => 404,
                'message' => $entity[0]."Id n'existe pas"
            ];
    
            $event->setResponse(new JsonResponse($data));

        }else{
            // I manage the error 500
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
