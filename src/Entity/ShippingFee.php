<?php

namespace App\Entity;

use App\Repository\ShippingFeeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShippingFeeRepository::class)
 */
class ShippingFee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $minAmount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinAmount(): ?string
    {
        return $this->minAmount;
    }

    public function setMinAmount(string $minAmount): self
    {
        $this->minAmount = $minAmount;

        return $this;
    }

    public function getFee(): ?string
    {
        return $this->fee;
    }

    public function setFee(string $fee): self
    {
        $this->fee = $fee;

        return $this;
    }
}
