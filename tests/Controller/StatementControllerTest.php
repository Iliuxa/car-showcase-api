<?php

namespace App\Tests\Controller;

use App\Entity\Car;
use App\Entity\CreditProgram;
use App\Entity\Statement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StatementControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    private EntityManagerInterface $entityManager;

    public function testSave(): void
    {
        $car = $this->entityManager->getRepository(Car::class)->findOneBy([]);
        $creditProgram = $this->entityManager->getRepository(CreditProgram::class)->findOneBy([]);

        $this->assertNotNull($car, "Test Car not found in database.");
        $this->assertNotNull($creditProgram, "Test Credit Program not found in database.");

        $requestData = [
            'carId' => $car->getId(),
            'programId' => $creditProgram->getId(),
            'initialPayment' => 150000,
            'loanTerm' => 60
        ];

        $this->client->request('POST', '/api/v1/request', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));

        $this->assertResponseIsSuccessful();

        $responseBody = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertTrue($responseBody['success']);

        $savedStatement = $this->entityManager->getRepository(Statement::class)->findOneBy([
            'car' => $requestData['carId'],
            'creditProgram' => $requestData['programId'],
            'initialPayment' => $requestData['initialPayment'],
            'loanTerm' => $requestData['loanTerm']
        ]);

        $this->assertNotNull($savedStatement, "The statement was not saved in the database.");

        $requestData['carId'] = 10000000;
        $this->client->request('POST', '/api/v1/request', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));
        $this->assertResponseStatusCodeSame(404);

        $requestData['carId'] = $car->getId();
        $requestData['programId'] = 10000000;
        $this->client->request('POST', '/api/v1/request', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));
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