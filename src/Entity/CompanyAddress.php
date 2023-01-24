<?php

namespace App\Entity;

use App\Repository\CompanyAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CompanyAddressRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $zipCode = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'companyAddress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CountryDictionary $countryDictionary = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var string|null
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private $slug;

    #[ORM\OneToOne(mappedBy: 'companyAddress', cascade: ['persist', 'remove'])]
    private ?CompanyAddressAdditionalInfo $companyAddressAdditionalInfo = null;

    #[ORM\OneToMany(mappedBy: 'companyAddress', targetEntity: CompanyOpenHours::class)]
    private Collection $companyOpenHours;

    #[ORM\ManyToOne(inversedBy: 'companyAddress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProvinceDictionary $provinceDictionary = null;

    #[ORM\ManyToOne(inversedBy: 'companyAddresses')]
    private ?Company $company = null;

    public function __construct()
    {
        $this->companyOpenHours = new ArrayCollection();
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCountryDictionary(): ?CountryDictionary
    {
        return $this->countryDictionary;
    }

    public function setCountryDictionary(?CountryDictionary $countryDictionary): self
    {
        $this->countryDictionary = $countryDictionary;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getCompanyAddressAdditionalInfo(): ?CompanyAddressAdditionalInfo
    {
        return $this->companyAddressAdditionalInfo;
    }

    public function setCompanyAddressAdditionalInfo(?CompanyAddressAdditionalInfo $companyAddressAdditionalInfo): self
    {
        // unset the owning side of the relation if necessary
        if ($companyAddressAdditionalInfo === null && $this->companyAddressAdditionalInfo !== null) {
            $this->companyAddressAdditionalInfo->setCompanyAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($companyAddressAdditionalInfo !== null && $companyAddressAdditionalInfo->getCompanyAddress() !== $this) {
            $companyAddressAdditionalInfo->setCompanyAddress($this);
        }

        $this->companyAddressAdditionalInfo = $companyAddressAdditionalInfo;

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

    public function getProvinceDictionary(): ?ProvinceDictionary
    {
        return $this->provinceDictionary;
    }

    public function setProvinceDictionary(?ProvinceDictionary $provinceDictionary): self
    {
        $this->provinceDictionary = $provinceDictionary;

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
}
