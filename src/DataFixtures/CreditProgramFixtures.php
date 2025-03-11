<?php

namespace App\DataFixtures;

use App\Entity\CreditProgram;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreditProgramFixtures extends Fixture
{
    const creditProgramsData = [
        [
            'title' => 'Alfa Energy',
            'minInitialPayment' => 200000,
            'maxLoanTerm' => 60,
            'interestRate' => 12.3,
        ], [
            'title' => 'T Energy',
            'minInitialPayment' => 100000,
            'maxLoanTerm' => 72,
            'interestRate' => 39.9,
        ], [
            'title' => 'Sber Energy',
            'minInitialPayment' => 500000,
            'maxLoanTerm' => 48,
            'interestRate' => 5.1,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::creditProgramsData as $creditProgramData) {
            $creditProgram = (new CreditProgram())
                ->setTitle($creditProgramData['title'])
                ->setMinInitialPayment($creditProgramData['minInitialPayment'])
                ->setMaxLoanTerm($creditProgramData['maxLoanTerm'])
                ->setInterestRate($creditProgramData['interestRate']);

            $manager->persist($creditProgram);
        }
        $manager->flush();
    }
}