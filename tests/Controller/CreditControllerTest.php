<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreditControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function testCalculate(): void
    {
        $this->client->request('GET', '/api/v1/credit/calculate', [
            'price' => 1401000,
            'initialPayment' => 200000.56,
            'loanTerm' => 64,
        ]);
        $this->assertResponseIsSuccessful();

        $responseBody = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertNotEmpty($responseBody);

        // Проверяем, что структура ответа соответствует ожидаемой
        $this->assertArrayHasKey('programId', $responseBody);
        $this->assertArrayHasKey('interestRate', $responseBody);
        $this->assertArrayHasKey('monthlyPayment', $responseBody);
        $this->assertArrayHasKey('title', $responseBody);

        // Проверяем, что значения имеют правильные типы
        $this->assertIsInt($responseBody['programId']);
        $this->assertIsFloat($responseBody['interestRate']);
        $this->assertIsInt($responseBody['monthlyPayment']);
        $this->assertIsString($responseBody['title']);
    }

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }
}