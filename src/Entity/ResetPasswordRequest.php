<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ResetPasswordRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'resetPasswordRequest')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(length: 20)]
    private ?string $selector = null;

    #[ORM\Column(length: 100)]
    private ?string $hashed_token = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $requested_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $expires_at = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->requested_at = new \DateTimeImmutable();
        $this->expires_at = $this->requested_at->add(new \DateInterval('PT1H'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSelector(): ?string
    {
        return $this->selector;
    }

    public function setSelector(string $selector): self
    {
        $this->selector = $selector;

        return $this;
    }

    public function getHashedToken(): ?string
    {
        return $this->hashed_token;
    }

    public function setHashedToken(string $hashed_token): self
    {
        $this->hashed_token = $hashed_token;

        return $this;
    }

    public function getRequestedAt(): ?\DateTimeImmutable
    {
        return $this->requested_at;
    }

    public function setRequestedAt(\DateTimeImmutable $requested_at): self
    {
        $this->requested_at = $requested_at;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expires_at;
    }

    public function setExpiresAt(\DateTimeImmutable $expires_at): self
    {
        $this->expires_at = $expires_at;

        return $this;
    }

    public function isExpired(): bool
    {
        $currentTime = new \DateTimeImmutable();
        return $currentTime > $this->getExpiresAt();
    }
}
