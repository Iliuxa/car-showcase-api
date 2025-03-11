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

final class StatementController extends AbstractController
{
    #[Route('/request', name: 'statement_save', methods: ['POST'], format: 'JSON')]
    public function save(
        #[MapRequestPayload] StatementDto $dto,
        EntityManagerInterface            $entityManager
    ): JsonResponse
    {
        $car = $entityManager->getReference(Car::class, $dto->carId)
            ?? throw new NotFoundHttpException('Car not found');

        $creditProgram = $entityManager->getReference(CreditProgram::class, $dto->programId)
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
