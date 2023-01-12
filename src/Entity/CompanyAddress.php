<?php

namespace App\Entity;

use App\Repository\CompanyAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Valid;

#[SoftDeleteable(fieldName: "deletedAt", timeAware: false)]
#[ORM\Entity(repositoryClass: CompanyAddressRepository::class)]
class CompanyAddress
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

    #[ORM\Column(length: 255, nullable: true)]
    #[NotBlank(message: 'entity.company_address.assert.not_blank')]
    protected ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[NotBlank(message: 'entity.company_address.assert.not_blank')]
    #[Regex(pattern: '/^[0-9]{2}-[0-9]{3}$/i', message: 'entity.company_address.assert.post_code')]
    private ?string $postCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[NotBlank(message: 'entity.company_address.assert.not_blank')]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[NotBlank(message: 'entity.company_address.assert.not_blank')]
    private ?string $buildingNumber = null;



    #[ORM\OneToMany(
        mappedBy: 'companyAddress',
        targetEntity: CompanyAdditionalInfo::class,
        cascade: ['persist','remove']
    )]
    #[Valid]
    private Collection $companyAdditionalInfos;

    #[ORM\ManyToOne(inversedBy: 'companyAddress')]
    private ?Company $company = null;

    #[ORM\ManyToMany(targetEntity: Service::class, inversedBy: 'companyAddresses', cascade: ['persist','remove'])]
    private Collection $service;

    #[ORM\OneToMany(
        mappedBy: 'companyAddress',
        targetEntity: CompanyOpenHours::class,
        cascade: ['persist','remove'],
        orphanRemoval: true
    )]
    private Collection $companyOpenHours;

    public function __construct()
    {
        $this->companyAdditionalInfos = new ArrayCollection();
        $this->service = new ArrayCollection();
        $this->companyOpenHours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getBuildingNumber(): ?string
    {
        return $this->buildingNumber;
    }

    public function setBuildingNumber(?string $buildingNumber): self
    {
        $this->buildingNumber = $buildingNumber;

        return $this;
    }


    /**
     * @return Collection<int, CompanyAdditionalInfo>
     */
    public function getCompanyAdditionalInfos(): Collection
    {
        return $this->companyAdditionalInfos;
    }

    public function addCompanyAdditionalInfo(CompanyAdditionalInfo $companyAdditionalInfo): self
    {
        if (!$this->companyAdditionalInfos->contains($companyAdditionalInfo)) {
            $this->companyAdditionalInfos->add($companyAdditionalInfo);
            $companyAdditionalInfo->setCompanyAddress($this);
        }

        return $this;
    }

    public function removeCompanyAdditionalInfo(CompanyAdditionalInfo $companyAdditionalInfo): self
    {
        if ($this->companyAdditionalInfos->removeElement($companyAdditionalInfo)) {
            // set the owning side to null (unless already changed)
            if ($companyAdditionalInfo->getCompanyAddress() === $this) {
                $companyAdditionalInfo->setCompanyAddress(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): self
    {
        if (!$this->service->contains($service)) {
            $this->service->add($service);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        $this->service->removeElement($service);

        return $this;
    }

    /**
     * @return Collection<int, CompanyOpenHours>
     */
    public function getCompanyOpenHours(): Collection
    {
        return $this->companyOpenHours;
    }

    public function addCompanyOpenHour(CompanyOpenHours $companyOpenHour): self
    {
        if (!$this->companyOpenHours->contains($companyOpenHour)) {
            $this->companyOpenHours->add($companyOpenHour);
            $companyOpenHour->setCompanyAddress($this);
        }

        return $this;
    }

    public function removeCompanyOpenHour(CompanyOpenHours $companyOpenHour): self
    {
        if ($this->companyOpenHours->removeElement($companyOpenHour)) {
            // set the owning side to null (unless already changed)
            if ($companyOpenHour->getCompanyAddress() === $this) {
                $companyOpenHour->setCompanyAddress(null);
            }
        }

        return $this;
    }
}
