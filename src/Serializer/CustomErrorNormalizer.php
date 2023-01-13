<?php

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomErrorNormalizer implements NormalizerInterface
{
    public function normalize($exception, string $format = null, array $context = []): array
    {
        return [
            'exception' => [
                'message' => $exception->getMessage(),
                'code' => $exception->getStatusCode(),
            ],
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof FlattenException;
    }
}
