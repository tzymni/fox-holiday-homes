<?php

namespace App\Domain\HouseManagement\Repository;

use App\Domain\HouseManagement\Entity\House;

interface HouseRepositoryInterface
{
    public function save(House $house);

    public function findById(int $id): ?House;
}