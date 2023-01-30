<?php

namespace App\Entity;

use App\Repository\ProvinceDictionaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProvinceDictionaryRepository::class)]
class ProvinceDictionary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\OneToOne(mappedBy: 'province')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'provinceDictionary', targetEntity: CompanyAddress::class)]
    private Collection $companyAddress;

    public function __construct()
    {
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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        // set the owning side of the relation if necessary
        if ($company->getProvince() !== $this) {
            $company->setProvince($this);
        }

        $this->company = $company;

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
            $companyAddress->setProvinceDictionary($this);
        }

        return $this;
    }

    public function removeCompanyAddress(CompanyAddress $companyAddress): self
    {
        if ($this->companyAddress->removeElement($companyAddress)) {
            // set the owning side to null (unless already changed)
            if ($companyAddress->getProvinceDictionary() === $this) {
                $companyAddress->setProvinceDictionary(null);
            }
        }

        return $this;
    }
}
