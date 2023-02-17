<?php

namespace App\Infrastructure\Mapper;

use App\Infrastructure\Validation\ValidationException;

interface RequestMapperInterface
{
    /**
     * Maps request into given DTO object.
     *
     * @param class-string<T> $dtoClass DTO object used to map incoming request.
     * @template T
     * @return T Mapped DTO object.
     * @throws ValidationException
     */
    public function mapAndValidate(string $dtoClass);
}