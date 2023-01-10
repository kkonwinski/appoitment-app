<?php

namespace App\Entity;

use App\Repository\CompanyOpenHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyOpenHoursRepository::class)]
class CompanyOpenHours
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'entity.company_opening_hours.assert.not_blank')]
    private ?string $dayName = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'entity.company_opening_hours.assert.not_blank')]
    private ?\DateTimeInterface $openFrom = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'entity.company_opening_hours.assert.not_blank')]
    private ?\DateTimeInterface $openTo = null;

    #[ORM\ManyToOne(inversedBy: 'companyOpenHours',cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyAddress $companyAddress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayName(): ?string
    {
        return $this->dayName;
    }

    public function setDayName(string $dayName): self
    {
        $this->dayName = $dayName;

        return $this;
    }

    public function getOpenFrom(): ?\DateTimeInterface
    {
        return $this->openFrom;
    }

    public function setOpenFrom(\DateTimeInterface $openFrom): self
    {
        $this->openFrom = $openFrom;

        return $this;
    }

    public function getOpenTo(): ?\DateTimeInterface
    {
        return $this->openTo;
    }

    public function setOpenTo(\DateTimeInterface $openTo): self
    {
        $this->openTo = $openTo;

        return $this;
    }

    public function getCompanyAddress(): ?CompanyAddress
    {
        return $this->companyAddress;
    }

    public function setCompanyAddress(?CompanyAddress $companyAddress): self
    {
        $this->companyAddress = $companyAddress;

        return $this;
    }

    #[Assert\Callback]
    public function validateOpenTime(ExecutionContextInterface $context, $payload): void
    {
        //if openFrom is less than openTo, if not add violation
        if ($this->openTo && $this->openFrom > $this->openTo) {
            $context->buildViolation('entity.company_opening_hours.assert.time_from_greater_than_time_to')
                ->setTranslationDomain('validators')
                ->atPath('openFrom')
                ->addViolation();
        }
    }
}
