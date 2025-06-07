<?php

namespace App\Application\HouseManagement\Command;

readonly class AddHouseCommand
{
    public function __construct(
        public string $name,
        public int    $maxGuests,
        public float  $area
    ) {}
}