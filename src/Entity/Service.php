<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[SoftDeleteable(fieldName: "deletedAt", timeAware: false)]
#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message: 'entity.service.not_blank')]
    private ?string $name = null;

    #[ORM\Column]
    #[Regex(pattern: "/\d+/")]
    private ?int $duration = 0;



    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToMany(targetEntity: CompanyAddress::class, mappedBy: 'service',cascade: ['persist','remove'])]
    private Collection $companyAddresses;

    public function __construct()
    {
        $this->companyAddresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, CompanyAddress>
     */
    public function getCompanyAddresses(): Collection
    {
        return $this->companyAddresses;
    }

    public function addCompanyAddress(CompanyAddress $companyAddress): self
    {
        if (!$this->companyAddresses->contains($companyAddress)) {
            $this->companyAddresses->add($companyAddress);
            $companyAddress->addService($this);
        }

        return $this;
    }

    public function removeCompanyAddress(CompanyAddress $companyAddress): self
    {
        if ($this->companyAddresses->removeElement($companyAddress)) {
            $companyAddress->removeService($this);
        }

        return $this;
    }
}
