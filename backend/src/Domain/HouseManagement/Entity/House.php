<?php

namespace App\Domain\HouseManagement\Entity;

use App\Domain\UserManagement\Entity\User;
use App\Infrastructure\HouseManagement\Repository\DoctrineHouseRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'houses')]
#[ORM\HasLifecycleCallbacks]
class House
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $maxGuests;

    #[ORM\Column(type: 'float')]
    private float $areaInSquareMeters;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'created_by', referencedColumnName: 'id', nullable: true)]
    private ?User $createdBy = null;


    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $createdAtUtc;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $updatedAtUtc;

    public function __construct(
        string $id,
        string $name,
        int $maxGuests,
        float $areaInSquareMeters
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->maxGuests = $maxGuests;
        $this->areaInSquareMeters = $areaInSquareMeters;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxGuests(): int
    {
        return $this->maxGuests;
    }

    public function getAreaInSquareMeters(): float
    {
        return $this->areaInSquareMeters;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }


    /**
     * @throws \DateMalformedStringException
     */
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAtUtc = new DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $this->updatedAtUtc = new DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAtUtc = new DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public function getCreatedAtUtc(): DateTimeImmutable
    {
        return $this->createdAtUtc;
    }

    public function getUpdatedAtUtc(): ?DateTimeImmutable
    {
        return $this->updatedAtUtc;
    }

    public function changeMaxGuests(int $maxGuests): void
    {
        $this->maxGuests = $maxGuests;
    }

    public function changeAreaInSquareMeters(float $areaInSquareMeters): void
    {
        $this->areaInSquareMeters = $areaInSquareMeters;
    }


}
