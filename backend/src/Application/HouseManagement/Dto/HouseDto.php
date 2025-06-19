<?php

namespace App\Application\HouseManagement\Dto;

use DateTimeImmutable;

class HouseDto
{
    public function __construct(
        public string $id,
        public string $name,
        public int $maxGuests,
        public float $areaInSquareMeters,
        public ?string $createdById,
        public DateTimeImmutable $createdAtUtc,
        public DateTimeImmutable $updatedAtUtc
    ) {}
}