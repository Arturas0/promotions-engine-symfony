<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ServiceException extends HttpException
{
    public function __construct(public ServiceExceptionData $exceptionData)
    {
        $statusCode = $exceptionData->getStatusCode();
        $message = $exceptionData->getType();

        parent::__construct($statusCode, $message);
    }

    public function getExceptionData(): ServiceExceptionData
    {
        return $this->exceptionData;
    }
}