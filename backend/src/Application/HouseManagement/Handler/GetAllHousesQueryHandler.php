<?php

namespace App\Application\HouseManagement\Handler;

use App\Application\HouseManagement\Dto\HouseDto;
use App\Application\HouseManagement\Query\GetAllHousesQuery;
use App\Domain\HouseManagement\Entity\House;
use App\Domain\HouseManagement\Repository\HouseRepositoryInterface;

readonly class GetAllHousesQueryHandler
{


    public function __construct(private HouseRepositoryInterface $houseRepository)
    {
    }

    public function __invoke(GetAllHousesQuery $query): array
    {
        $houses = $this->houseRepository->findAll();

        return array_map(fn($house) => new HouseDto(
            $house->getId(),
            $house->getName(),
            $house->getMaxGuests(),
            $house->getAreaInSquareMeters(),
            $house->getCreatedBy()?->getId(),
            $house->getCreatedAtUtc(),
            $house->getUpdatedAtUtc()
        ), $houses);
    }


}