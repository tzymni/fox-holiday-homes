<?php

namespace App\Infrastructure\UserManagement\Jwt;

use App\Domain\UserManagement\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
class RefreshToken
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $token;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private UserInterface $user;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $expiresAt;

    public function __construct(string $token, UserInterface $user, \DateTimeInterface $expiresAt)
    {
        $this->token = $token;
        $this->user = $user;
        $this->expiresAt = $expiresAt;
    }

    // getters/setters
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getExpiresAt(): \DateTimeInterface {
        return $this->expiresAt;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
