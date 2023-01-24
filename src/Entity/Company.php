<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
class Company
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

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyAddress::class, orphanRemoval: true)]
    private Collection $companyAddress;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyAddress::class)]
    private Collection $companyAddresses;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\OneToOne(inversedBy: 'company', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProvinceDictionary $province = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;


    /**
     * @var string|null
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private $slug;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zipCode = null;

    #[ORM\ManyToOne(inversedBy: 'company')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CountryDictionary $countryDictionary = null;

    public function __construct()
    {
        $this->companyAddress = new ArrayCollection();
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

    /**
     * @return Collection<int, CompanyAddress>
     */
    public function getCompanyAddress(): Collection
    {
        return $this->companyAddress;
    }

    public function addCompanyAddress(CompanyAddress $companyAddress): self
    {
        if (!$this->companyAddress->contains($companyAddress)) {
            $this->companyAddress->add($companyAddress);
            $companyAddress->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyAddress(CompanyAddress $companyAddress): self
    {
        if ($this->companyAddress->removeElement($companyAddress)) {
            // set the owning side to null (unless already changed)
            if ($companyAddress->getCompany() === $this) {
                $companyAddress->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyAddress>
     */
    public function getCompanyAddresses(): Collection
    {
        return $this->companyAddresses;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
    public function getSlug()
    {
        return $this->slug;
    }
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getProvince(): ?ProvinceDictionary
    {
        return $this->province;
    }

    public function setProvince(ProvinceDictionary $province): self
    {
        $this->province = $province;

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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

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
}
