<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
trait Employee
{


    #[ORM\ManyToOne(inversedBy: 'user')]
    private ?Company $company = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['firstname', 'lastname'])]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: EmployeeSchedule::class, orphanRemoval: true)]
    private Collection $employeeSchedules;


    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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
     * @return Collection<int, EmployeeSchedule>
     */
    public function getEmployeeSchedules(): Collection
    {
        return $this->employeeSchedules;
    }

    public function addEmployeeSchedule(EmployeeSchedule $employeeSchedule): self
    {
        if (!$this->employeeSchedules->contains($employeeSchedule)) {
            $this->employeeSchedules->add($employeeSchedule);
            $employeeSchedule->setUser($this);
        }

        return $this;
    }

    public function removeEmployeeSchedule(EmployeeSchedule $employeeSchedule): self
    {
        if ($this->employeeSchedules->removeElement($employeeSchedule)) {
            // set the owning side to null (unless already changed)
            if ($employeeSchedule->getUser() === $this) {
                $employeeSchedule->setUser(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getFullName();
    }
}
