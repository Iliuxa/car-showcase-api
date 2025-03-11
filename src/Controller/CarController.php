<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0',
    description: "API documentation for car showcase API",
    title: "Statements API",
)]
final class CarController extends AbstractController
{
    #[OA\Get(
        path: '/cars/{id}',
        summary: 'Получение информации о машине по id',
        tags: ['car'],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Идентификатор машины",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 123)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Информация о машине',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", type: "integer", example: 1),
                        new OA\Property(property: "brand", ref: "#/components/schemas/Brand"),
                        new OA\Property(property: "photo", type: "string", format: "base64", example: "data:image/png;base64,iVBORw0KGgoAAAANSUhEU", nullable: true),
                        new OA\Property(property: "price", type: "integer", example: 3500000)
                    ],
                    type: "object"
                )
            ),
            new OA\Response(response: 404, description: 'User not found'),
        ]
    )]
    #[Route('/cars/{id}', name: 'get_cars', methods: ['GET'], format: 'JSON')]
    public function get(Car $car): JsonResponse
    {
        return $this->json($car, 200, [], [AbstractNormalizer::IGNORED_ATTRIBUTES => ['model']]);
    }

    #[OA\Get(
        path: "/cars",
        summary: "Получение всех машин",
        tags: ['car'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Информация о машинах',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: "#/components/schemas/Car")
                )
            ),
            new OA\Response(response: 404, description: 'Users not found'),
        ]
    )]
    #[Route('/cars', name: 'get_all_cars', methods: ['GET'], format: 'JSON')]
    public function getAll(
        #[MapEntity(class: Car::class, expr: 'repository.findAll()')]
        iterable $cars
    ): JsonResponse
    {
        return $this->json($cars);
    }
}
