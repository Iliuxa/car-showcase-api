<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints\NotBlank;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "StatementDto",
    required: ["carId", "programId", "initialPayment", "loanTerm"],
    properties: [
        new OA\Property(property: "carId", type: "integer", example: 1),
        new OA\Property(property: "programId", type: "integer", example: 2),
        new OA\Property(property: "initialPayment", type: "integer", example: 200000),
        new OA\Property(property: "loanTerm", type: "integer", example: 5)
    ],
    type: "object"
)]
class StatementDto
{
    public function __construct(
        #[NotBlank]
        public int $carId,

        #[NotBlank]
        public int $programId,

        #[NotBlank]
        public int $initialPayment,

        #[NotBlank]
        public int $loanTerm,
    )
    {
    }
}