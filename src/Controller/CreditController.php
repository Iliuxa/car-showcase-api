<?php

namespace App\Controller;

use App\Repository\CreditProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class CreditController extends AbstractController
{
    #[Route('/credit/calculate', name: 'credit_calculate', methods: ['GET'], format: 'JSON')]
    public function calculate(
        #[MapQueryParameter] int   $price,
        #[MapQueryParameter] float $initialPayment,
        #[MapQueryParameter] int   $loanTerm,
        CreditProgramRepository    $repository
    ): JsonResponse
    {
        $program = $repository->findBestProgram($initialPayment, $loanTerm)
            ?? throw new NotFoundHttpException('No suitable credit program found');

        $rate = $program->getInterestRate() / 100 / 12;
        $loanAmount = $price - $initialPayment;
        $monthlyPayment = ($loanAmount * $rate) / (1 - pow(1 + $rate, -$loanTerm));

        return $this->json([
            'programId' => $program->getId(),
            'interestRate' => $program->getInterestRate(),
            'monthlyPayment' => round($monthlyPayment),
            'title' => $program->getTitle()
        ]);
    }
}
