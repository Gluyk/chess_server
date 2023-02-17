<?php

namespace App\Infrastructure\Mapper;

use App\Infrastructure\Validation\ValidationError;
use App\Infrastructure\Validation\ValidationException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class RequestMapper implements RequestMapperInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private ValidatorInterface $validator,
        private JsonMapperInterface $jsonMapper
    ) {
    }

    /**
     * @inheritDoc
     */
    public function mapAndValidate(string $dtoClass)
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            throw new \Exception('Unable to get request');
        }
        $requestData = $request->getContent();
        if (!$requestData) {
            throw new \DomainException('Missing request payload');
        }
        $requestObjectDto = $this->jsonMapper->map(
            $request->getContent(),
            $dtoClass
        );
        $this->validate($requestObjectDto);
        return $requestObjectDto;
    }

    /**
     * @param object $requestDto
     * @return void
     * @throws ValidationException
     */
    private function validate(object $requestDto): void
    {
        $validationResult = $this->validator->validate($requestDto);

        if (count($validationResult) > 0) {
            throw new ValidationException($this->prepareErrors($validationResult));
        }
    }

    /**
     * @param ConstraintViolationListInterface $validationErrors
     * @return ValidationError[]
     */
    private function prepareErrors(ConstraintViolationListInterface $validationErrors): array
    {
        $mappedErrors = [];
        foreach ($validationErrors as $index => $errorObject) {
            /** @var ConstraintViolationInterface $error */
            $error = $validationErrors[$index];
            $mappedErrors[] = new ValidationError($error->getPropertyPath(), $error->getMessage(), $error);
        }

        return $mappedErrors;
    }
}