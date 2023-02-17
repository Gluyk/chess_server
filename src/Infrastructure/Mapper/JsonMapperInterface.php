<?php

namespace App\Infrastructure\Mapper;

interface JsonMapperInterface
{
    /**
     * @param mixed $data
     * @param class-string<T> $dto
     * @return T
     * @template T
     */
    public function map(mixed $data, string $dto);
}