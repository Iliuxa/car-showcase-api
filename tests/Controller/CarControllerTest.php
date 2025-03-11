<?php

namespace App\Tests\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    private EntityManagerInterface $entityManager;

    public function testGetAll(): void
    {
        $this->client->request('GET', '/api/v1/cars', [], [], ['CONTENT_TYPE' => 'application/json']);
        $this->assertResponseIsSuccessful();
        $responseBody = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertNotEmpty($responseBody);

        $cars = $this->entityManager->getRepository(Car::class)->findAll();
        $this->AssertCount(count($cars), $responseBody);

        $carsArray = array_map(fn(Car $car) => [
            'id' => $car->getId(),
            'brand' => [
                'id' => $car->getBrand()->getId(),
                'name' => $car->getBrand()->getName(),
            ],
            'photo' => $car->getPhoto(),
            'price' => $car->getPrice(),
        ], $cars);


        usort($carsArray, fn($a, $b) => $a['id'] <=> $b['id']);
        usort($responseBody, fn($a, $b) => $a['id'] <=> $b['id']);

        $this->assertEquals($carsArray, $responseBody);
    }

    public function testGet(): void
    {
        $cars = $this->entityManager->getRepository(Car::class)->findAll();
        $this->assertNotEmpty($cars);
        $car = array_shift($cars);

        $this->client->request('GET', '/api/v1/cars/' . $car->getId(), [], [], ['CONTENT_TYPE' => 'application/json']);
        $this->assertResponseIsSuccessful();
        $responseBody = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertNotEmpty($responseBody);

        $carArray = [
            'id' => $car->getId(),
            'brand' => [
                'id' => $car->getBrand()->getId(),
                'name' => $car->getBrand()->getName(),
            ],
            'model' => [
                'id' => $car->getModel()->getId(),
                'name' => $car->getModel()->getName(),
            ],
            'photo' => $car->getPhoto(),
            'price' => $car->getPrice(),
        ];
        $this->assertEquals($carArray, $responseBody);


        $this->client->request('GET', '/api/v1/cars/10000000', [], [], ['CONTENT_TYPE' => 'application/json']);
        $this->assertResponseStatusCodeSame(404);
    }

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::getContainer();

        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}