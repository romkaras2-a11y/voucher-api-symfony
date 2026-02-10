<?php //Datenmodell  Entity: Voucher

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "voucher")]
class Voucher
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50, unique: true)]
    #[Assert\NotBlank]
    private ?string $code = null;

    #[ORM\Column(type: "string", length: 10)]
    #[Assert\Choice(choices: ["amount", "percent"])]
    private ?string $type = null;

    #[ORM\Column(type: "float")]
    #[Assert\NotBlank]
    private ?float $value = null;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $validFrom = null;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $validUntil = null;

    #[ORM\Column(type: "boolean")]
    private bool $multiUse = false;

    #[ORM\Column(type: "integer")]
    private int $maxRedemptions = 1;

    #[ORM\Column(type: "integer")]
    private int $currentRedemptions = 0;

    // =====================
    // Getters & Setters
    // =====================

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getValidFrom(): ?\DateTimeInterface
    {
        return $this->validFrom;
    }

    public function setValidFrom(\DateTimeInterface $validFrom): self
    {
        $this->validFrom = $validFrom;
        return $this;
    }

    public function getValidUntil(): ?\DateTimeInterface
    {
        return $this->validUntil;
    }

    public function setValidUntil(\DateTimeInterface $validUntil): self
    {
        $this->validUntil = $validUntil;
        return $this;
    }

    public function isMultiUse(): bool
    {
        return $this->multiUse;
    }

    public function setMultiUse(bool $multiUse): self
    {
        $this->multiUse = $multiUse;
        return $this;
    }

    public function getMaxRedemptions(): int
    {
        return $this->maxRedemptions;
    }

    public function setMaxRedemptions(int $maxRedemptions): self
    {
        $this->maxRedemptions = $maxRedemptions;
        return $this;
    }

    public function getCurrentRedemptions(): int
    {
        return $this->currentRedemptions;
    }

    // =====================
    // Utility Methods
    // =====================

    public function incrementRedemptions(): self
    {
        $this->currentRedemptions++;
        return $this;
    }

    public function isValid(): bool
    {
        $now = new \DateTime();
        return $this->validFrom <= $now && $now <= $this->validUntil;
    }

    public function canBeRedeemed(): bool
    {
        return $this->isValid() && ($this->multiUse || $this->currentRedemptions < $this->maxRedemptions);
    }
}



