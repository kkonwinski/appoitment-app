<?php

namespace App\Entity;

use App\Repository\CompanyOpenHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

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

    #[ORM\ManyToOne(inversedBy: 'companyOpenHours')]
    private ?CompanyAddress $companyAddress = null;

    #[ORM\Column(length: 255)]
    private ?string $dayName = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openFrom = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openTo = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
