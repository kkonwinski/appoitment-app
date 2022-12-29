<?php

namespace App\Entity;

use App\Repository\CompanyAdditionalInfoRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

#[SoftDeleteable(fieldName: "deletedAt", timeAware: false)]
#[ORM\Entity(repositoryClass: CompanyAdditionalInfoRepository::class)]
class CompanyAdditionalInfo
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
    #[Regex([
        'pattern' => '/^(\+48|0048|48|0)?[0-9]{9}$/',
        'message' => 'entity.company_additional_info.assert.phone',
    ])]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Regex(
        pattern:"/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
        message: 'entity.company_additional_info.assert.email'
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Url(message: 'entity.company_additional_info.assert.url')]
    private ?string $facebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Url(message: 'entity.company_additional_info.assert.url')]
    private ?string $instagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Url(message: 'entity.company_additional_info.assert.url')]
    private ?string $website = null;

    #[ORM\ManyToOne(inversedBy: 'companyAdditionalInfos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyAddress $companyAddress = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

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

    public function getCompanyAddress(): ?CompanyAddress
    {
        return $this->companyAddress;
    }

    public function setCompanyAddress(?CompanyAddress $companyAddress): self
    {
        $this->companyAddress = $companyAddress;

        return $this;
    }
}
