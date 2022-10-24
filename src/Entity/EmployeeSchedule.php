<?php

namespace App\Entity;

use App\Repository\EmployeeScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[ORM\Entity(repositoryClass: EmployeeScheduleRepository::class)]
class EmployeeSchedule
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

    #[ORM\ManyToOne(inversedBy: 'employeeSchedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dayFrom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dayTo = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $timeFrom = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeTo = null;

    #[ORM\Column]
    private ?bool $repeatInfinity = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDayFrom(): ?\DateTimeInterface
    {
        return $this->dayFrom;
    }

    public function setDayFrom(\DateTimeInterface $dayFrom): self
    {
        $this->dayFrom = $dayFrom;

        return $this;
    }

    public function getDayTo(): ?\DateTimeInterface
    {
        return $this->dayTo;
    }

    public function setDayTo(?\DateTimeInterface $dayTo): self
    {
        $this->dayTo = $dayTo;

        return $this;
    }

    public function getTimeFrom(): ?\DateTimeInterface
    {
        return $this->timeFrom;
    }

    public function setTimeFrom(\DateTimeInterface $timeFrom): self
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    public function getTimeTo(): ?\DateTimeInterface
    {
        return $this->timeTo;
    }

    public function setTimeTo(?\DateTimeInterface $timeTo): self
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    public function isRepeatInfinity(): ?bool
    {
        return $this->repeatInfinity;
    }

    public function setRepeatInfinity(bool $repeatInfinity): self
    {
        $this->repeatInfinity = $repeatInfinity;

        return $this;
    }
}
