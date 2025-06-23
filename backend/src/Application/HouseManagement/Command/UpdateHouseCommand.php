<?php

namespace App\Application\HouseManagement\Command;

class UpdateHouseCommand
{
    public function __construct(
        public string $id,
        public ?string $name,
        public ?int    $maxGuests,
        public ?float  $area
    ) {}
}
