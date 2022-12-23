<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[ORM\Entity(repositoryClass: CompanyRepository::class)]
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

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: User::class)]
    private Collection $user;


    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyAddress::class)]
    protected Collection $companyAddresses;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyAdditionalInfo::class, orphanRemoval: true)]
    private Collection $companyAdditionalInfo;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->companyAddresses = new ArrayCollection();
        $this->companyAdditionalInfo = new ArrayCollection();
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
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
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
            $companyAddress->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyAddress(CompanyAddress $companyAddress): self
    {
        if ($this->companyAddresses->removeElement($companyAddress)) {
            // set the owning side to null (unless already changed)
            if ($companyAddress->getCompany() === $this) {
                $companyAddress->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyAdditionalInfo>
     */
    public function getCompanyAdditionalInfo(): Collection
    {
        return $this->companyAdditionalInfo;
    }

    public function addCompanyAdditionalInfo(CompanyAdditionalInfo $companyAdditionalInfo): self
    {
        if (!$this->companyAdditionalInfo->contains($companyAdditionalInfo)) {
            $this->companyAdditionalInfo->add($companyAdditionalInfo);
            $companyAdditionalInfo->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyAdditionalInfo(CompanyAdditionalInfo $companyAdditionalInfo): self
    {
        // set the owning side to null (unless already changed)
        if (
            $this->companyAdditionalInfo->removeElement($companyAdditionalInfo) &&
            $companyAdditionalInfo->getCompany() === $this
        ) {
            $companyAdditionalInfo->setCompany(null);
        }

        return $this;
    }
}
