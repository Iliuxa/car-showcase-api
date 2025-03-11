<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints\NotBlank;

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