<?php

namespace App\Infrastructure\Validation;

final class ValidationException extends \Exception
{
    /**
     * @param array<ValidationError> $validationErrors
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        private readonly array $validationErrors,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ValidationError[]
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}
