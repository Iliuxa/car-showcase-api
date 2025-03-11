<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class CarController extends AbstractController
{
    #[Route('/cars/{id}', name: 'get_cars', methods: ['GET'], format: 'JSON')]
    public function get(Car $car): JsonResponse
    {
        return $this->json($car, 200, [], [AbstractNormalizer::IGNORED_ATTRIBUTES => ['model']]);
    }

    #[Route('/cars', name: 'get_all_cars', methods: ['GET'], format: 'JSON')]
    public function getAll(
        #[MapEntity(class: Car::class, expr: 'repository.findAll()')]
        iterable $cars
    ): JsonResponse
    {
        return $this->json($cars);
    }
}
