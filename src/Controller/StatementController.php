<?php

namespace App\Controller;

use App\Dto\StatementDto;
use App\Entity\Car;
use App\Entity\CreditProgram;
use App\Entity\Statement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final class StatementController extends AbstractController
{
    #[OA\Post(
        path: "/api/v1/request",
        summary: "Создание заявки на кредит",
        requestBody: new OA\RequestBody(
            description: "Данные для создания заявки",
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/StatementDto")
        ),
        tags: ["statement"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Заявка успешно создана",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true)
                    ],
                    type: "object"
                )
            ),
            new OA\Response(response: 400, description: "Validation error"),
            new OA\Response(response: 404, description: "Car or credit program not found"),
        ]
    )]
    #[Route('/request', name: 'statement_save', methods: ['POST'], format: 'JSON')]
    public function save(
        #[MapRequestPayload] StatementDto $dto,
        EntityManagerInterface            $entityManager
    ): JsonResponse
    {
        $car = $entityManager->find(Car::class, $dto->carId)
            ?? throw new NotFoundHttpException('Car not found');

        $creditProgram = $entityManager->find(CreditProgram::class, $dto->programId)
            ?? throw new NotFoundHttpException('Credit Program not found');

        $statement = (new Statement())
            ->setCar($car)
            ->setCreditProgram($creditProgram)
            ->setInitialPayment($dto->initialPayment)
            ->setLoanTerm($dto->loanTerm);
        $entityManager->persist($statement);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }
}
