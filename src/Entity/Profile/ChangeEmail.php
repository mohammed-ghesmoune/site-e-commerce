<?php

namespace App\Entity\Profile;

use Symfony\Component\Validator\Constraints as Assert;


class ChangeEmail
{
    
    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "Adresse mail invalide"
     * )
     */
    private $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

}
