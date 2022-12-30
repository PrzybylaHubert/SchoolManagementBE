<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'receivedMessages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $recipient_id = null;

    #[ORM\ManyToOne(inversedBy: 'sendMessages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $addresse_id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $send_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipientId(): ?User
    {
        return $this->recipient_id;
    }

    public function setRecipientId(?User $recipient_id): self
    {
        $this->recipient_id = $recipient_id;

        return $this;
    }

    public function getAddresseId(): ?User
    {
        return $this->addresse_id;
    }

    public function setAddresseId(?User $addresse_id): self
    {
        $this->addresse_id = $addresse_id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSendDate(): ?\DateTimeInterface
    {
        return $this->send_date;
    }

    public function setSendDate(\DateTimeInterface $send_date): self
    {
        $this->send_date = $send_date;

        return $this;
    }
}
