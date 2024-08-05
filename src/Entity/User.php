<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $lastnames = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role", type="string", length=50, nullable=true)
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastnames(): ?string
    {
        return $this->lastnames;
    }

    public function setLastnames(string $lastnames): static
    {
        $this->lastnames = $lastnames;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function patch (array $data): static
    {
        if (array_key_exists('name', $data)) {
            $this->setName($data['name']);
        }
        if (array_key_exists('lastnames', $data)) {
            $this->setLastnames($data['lastnames']);
        }
        if (array_key_exists('email', $data)) {
            $this->setEmail($data['email']);
        }
        if (array_key_exists('password', $data)) {
            $this->setPassword($data['password']);
        }

        return $this;
    }


    public function eraseCredentials(){}


    public function getSalt(){
        return null;
    }

    public function getRoles(): array
    {
        return array('ROLE_USER');
    }

    public function getUserIdentifier(): string
    {
        return '';
    }

}