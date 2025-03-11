<?php

namespace App\Entity;

use App\Repository\CreditProgramRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditProgramRepository::class)]
class CreditProgram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?float $interestRate = null;

    #[ORM\Column]
    private ?float $minInitialPayment = null;

    #[ORM\Column]
    private ?int $maxLoanTerm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    public function setInterestRate(?float $interestRate): static
    {
        $this->interestRate = $interestRate;
        return $this;
    }

    public function getMinInitialPayment(): ?float
    {
        return $this->minInitialPayment;
    }

    public function setMinInitialPayment(?float $minInitialPayment): static
    {
        $this->minInitialPayment = $minInitialPayment;

        return $this;
    }

    public function getMaxLoanTerm(): ?int
    {
        return $this->maxLoanTerm;
    }

    public function setMaxLoanTerm(?int $maxLoanTerm): static
    {
        $this->maxLoanTerm = $maxLoanTerm;

        return $this;
    }
}
