<?php

namespace App\Infrastructure\Mapper;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class JsonMapper implements JsonMapperInterface
{
    /**
     * @inheritDoc
     */
    public function map(mixed $data, string $dto)
    {
        $encoders = [new JsonEncoder()];
        $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor()]);
        $normalizers = [new ObjectNormalizer(null, null, null, $extractor)];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->deserialize($data, $dto, 'json');
    }
}
