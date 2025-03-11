<?php

namespace App\Controller;

use App\Repository\CreditProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final class CreditController extends AbstractController
{
    #[OA\Get(
        path: "/api/v1/credit/calculate",
        summary: "Расчет кредита по указанным параметрам",
        tags: ["credit"],
        parameters: [
            new OA\Parameter(
                name: "price",
                description: "Цена автомобиля",
                in: "query",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1401000)
            ),
            new OA\Parameter(
                name: "initialPayment",
                description: "Первоначальный взнос (рубли с копейками)",
                in: "query",
                required: true,
                schema: new OA\Schema(type: "number", format: "float", example: 200000.56)
            ),
            new OA\Parameter(
                name: "loanTerm",
                description: "Срок кредита в месяцах",
                in: "query",
                required: true,
                schema: new OA\Schema(type: "integer", example: 64)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Результат расчета кредита",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "programId", type: "integer", example: 1),
                        new OA\Property(property: "interestRate", type: "number", format: "float", example: 12.3),
                        new OA\Property(property: "monthlyPayment", type: "integer", example: 24276),
                        new OA\Property(property: "title", type: "string", example: "Alfa Energy")
                    ],
                    type: "object"
                )
            ),
            new OA\Response(response: 404, description: "Credit program not found")
        ]
    )]
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
