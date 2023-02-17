<?php
// phpcs:ignoreFile
// TODO
// phpcs not supported readonly class from 8.2

namespace App\Infrastructure\Validation;

use Symfony\Component\Validator\ConstraintViolationInterface;

final readonly class ValidationError
{
    public function __construct(
        private string $parameter,
        private string $errorMessage,
        private ConstraintViolationInterface $originalError
    ) {
    }

    /**
     * @return string
     */
    public function getParameter(): string
    {
        return $this->parameter;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @return ConstraintViolationInterface
     */
    public function getOriginalErrorObject(): ConstraintViolationInterface
    {
        return $this->originalError;
    }
}
