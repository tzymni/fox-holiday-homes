<?php

namespace App\Application\HouseManagement\Handler;

use App\Application\HouseManagement\Dto\HouseDto;
use App\Application\HouseManagement\Query\GetHouseByIdQuery;
use App\Domain\HouseManagement\Entity\House;
use App\Domain\HouseManagement\Repository\HouseRepositoryInterface;

class GetHouseByIdQueryHandler
{


    public function __construct(private HouseRepositoryInterface $houseRepository)
    {
    }

    public function __invoke(GetHouseByIdQuery $query): ?HouseDto
    {
        $house = $this->houseRepository->findById($query->id);
        if (!$house) {
            return null;
        }

        return new HouseDto(
            $house->getId(),
            $house->getName(),
            $house->getMaxGuests(),
            $house->getAreaInSquareMeters(),
            $house->getCreatedBy()->getEmail(),
            $house->getCreatedAtUtc(),
            $house->getUpdatedAtUtc(),
        );
    }
}