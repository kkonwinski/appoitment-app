<?php

namespace App\Entity;

use App\Repository\CountryDictionaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryDictionaryRepository::class)]
class CountryDictionary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'countryDictionary', targetEntity: Company::class)]
    private Collection $company;

    #[ORM\OneToMany(mappedBy: 'countryDictionary', targetEntity: CompanyAddress::class)]
    private Collection $companyAddress;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->company = new ArrayCollection();
        $this->companyAddress = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->company->contains($company)) {
            $this->company->add($company);
            $company->setCountryDictionary($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->company->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getCountryDictionary() === $this) {
                $company->setCountryDictionary(null);
            }
        }

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
            $companyAddress->setCountryDictionary($this);
        }

        return $this;
    }

    public function removeCompanyAddress(CompanyAddress $companyAddress): self
    {
        if ($this->companyAddress->removeElement($companyAddress)) {
            // set the owning side to null (unless already changed)
            if ($companyAddress->getCountryDictionary() === $this) {
                $companyAddress->setCountryDictionary(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
