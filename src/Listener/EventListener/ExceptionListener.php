<?php
// phpcs:ignoreFile
// TODO
// phpcs not supported readonly class from 8.2

namespace App\Listener\EventListener;

use App\Infrastructure\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\InvalidArgumentException;

final readonly class ExceptionListener
{
    public function __construct(
        private KernelInterface $kernel,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $response = new JsonResponse();

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } elseif ($exception instanceof ValidationException) {
            $responseErrors = [];
            foreach ($exception->getValidationErrors() as $validationError) {
                $responseErrors[$validationError->getParameter()] = $validationError->getErrorMessage();
            }
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setData([
                'message' => 'Error while validating incoming payload.',
                'data' => [],
                'errors' => $responseErrors,
            ]);
        } elseif (
            $exception instanceof \DomainException ||
            $exception instanceof InvalidArgumentException
        ) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setData([
                'message' => $exception->getMessage(),
                'data' => [],
                'errors' => [],
            ]);
        } else {
            $response->setData([
                'message' => in_array($this->kernel->getEnvironment(), ['dev', 'test'])
                    ? $exception->getMessage()
                    : 'Internal error occurred.',
                'data' => [],
                'errors' => [],
            ]);
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
