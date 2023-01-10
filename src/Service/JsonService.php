<?php

namespace App\Service;

use App\Utility\ErrorList;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonService
{
    public function validateJson($content): array
    {
        $parameters = [];
        if (!($parameters = json_decode($content, true))) {
            throw new BadRequestHttpException(ErrorList::INVALID_JSON);
        }
        return $parameters;
    }
}