<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationExceptionData extends ServiceExceptionData
{
    public function __construct(
        protected int $statusCode,
        protected string $type,
        protected ConstraintViolationList $violations,
    ) {
        parent::__construct($statusCode, $type);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'violations' => $this->getValidationsArray(),
        ];
    }

    public function getValidationsArray(): array
    {
        $violations = [];

        foreach ($this->violations as $violation) {
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return $violations;
    }
}