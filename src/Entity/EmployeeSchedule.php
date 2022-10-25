<?php

namespace App\Entity;

use App\Repository\EmployeeScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
    #[Assert\NotBlank(message: 'entity.employee_schedule.not_blank')]
    #[Assert\Callback(callback: [self::class, 'validateDay'])]
    private ?\DateTimeInterface $dayFrom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\Callback(callback: [self::class, 'validateDay'])]
    private ?\DateTimeInterface $dayTo = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'entity.employee_schedule.not_blank')]
    #[Assert\Callback(callback: [self::class, 'validateTime'])]
    private ?\DateTimeInterface $timeFrom = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    #[Assert\Callback(callback: [self::class, 'validateTime'])]
    private ?\DateTimeInterface $timeTo = null;

    #[ORM\Column]
    #[Assert\Choice(['entity.employee_schedule.yes', 'entity.employee_schedule.no'])]
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

    //create function check if dayTo is greater than dayFrom, if not add violation
    public function validateDay(ExecutionContextInterface $context, $payload): void
    {
        if ($this->dayTo < $this->dayFrom) {
            $context->buildViolation('entity.employee_schedule.day_to_greater_than_day_from')
                ->atPath('dayTo')
                ->addViolation();
        }
        //dayFrom is no grater than dayTo, if not add violation
        if ($this->dayFrom > $this->dayTo) {
            $context->buildViolation('entity.employee_schedule.day_from_greater_than_day_to')
                ->atPath('dayFrom')
                ->addViolation();
        }
    }

    //create function check if timeTo is greater than timeFrom, if not add violation
    public function validateTime(ExecutionContextInterface $context, $payload): void
    {
        if ($this->timeTo < $this->timeFrom) {
            $context->buildViolation('entity.employee_schedule.time_to_greater_than_time_from')
                ->atPath('timeTo')
                ->addViolation();
        }
        //timeFrom is no grater than timeTo, if not add violation
        if ($this->timeFrom > $this->timeTo) {
            $context->buildViolation('entity.employee_schedule.time_from_greater_than_time_to')
                ->atPath('timeFrom')
                ->addViolation();
        }
        //timeFrom mus be bigger than time now
        if ($this->timeFrom < new \DateTime('now')) {
            $context->buildViolation('entity.employee_schedule.time_from_greater_than_time_now')
                ->atPath('timeFrom')
                ->addViolation();
        }
    }
}
