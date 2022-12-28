<?php

namespace App\Entity;

use App\Repository\CompanyAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

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
    protected ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $buildingNumber = null;

    #[ORM\ManyToOne(inversedBy: 'companyAddresses')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'companyAddress', targetEntity: CompanyAdditionalInfo::class, cascade: ['persist','remove'])]
    protected Collection $companyAdditionalInfos;

    public function __construct()
    {
        $this->companyAdditionalInfos = new ArrayCollection();
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
}
