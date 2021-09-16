<?php

namespace App\Entity\Profile;

use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{

    /**
     *
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/^(?=.*[0-9])(?=.*[a-zA-Z])[^ù ]{8,}$/",
     *     match=true,
     *     message="Au minimum 8 caractères dont au moins 1 lettre et 1 chiffre et en excluant les accents et les espaces"
     * )
     */
    private $password;

    /**
     * @Assert\NotBlank
     * 
     */
    private $oldPassword;

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getOldPassword(): string
    {
        return (string) $this->oldPassword;
    }

    public function setOldPassword(?string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

}
