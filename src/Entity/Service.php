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

    #[ORM\Column]
    #[Regex(pattern: "/\d+/")]
    private ?int $duration = 0;



    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToMany(targetEntity: ServiceDictionary::class, mappedBy: 'service')]
    private Collection $serviceDictionaries;

    #[ORM\ManyToOne(inversedBy: 'service')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyAddress $companyAddress = null;

    public function __construct()
    {
        $this->serviceDictionaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, ServiceDictionary>
     */
    public function getServiceDictionaries(): Collection
    {
        return $this->serviceDictionaries;
    }

    public function addServiceDictionary(ServiceDictionary $serviceDictionary): self
    {
        if (!$this->serviceDictionaries->contains($serviceDictionary)) {
            $this->serviceDictionaries->add($serviceDictionary);
            $serviceDictionary->addService($this);
        }

        return $this;
    }

    public function removeServiceDictionary(ServiceDictionary $serviceDictionary): self
    {
        if ($this->serviceDictionaries->removeElement($serviceDictionary)) {
            $serviceDictionary->removeService($this);
        }

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
}
