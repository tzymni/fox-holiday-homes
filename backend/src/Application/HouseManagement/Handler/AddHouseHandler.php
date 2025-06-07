<?php

namespace App\Application\HouseManagement\Handler;

use App\Application\HouseManagement\Command\AddHouseCommand;
use App\Domain\HouseManagement\Entity\House;
use App\Domain\HouseManagement\Repository\HouseRepositoryInterface;
use Symfony\Component\Uid\Uuid;

readonly class AddHouseHandler
{


    public function __construct(private HouseRepositoryInterface $houseRepository)
    {
    }

    public function handle(AddHouseCommand $command): void
    {
        $house = new House(
            Uuid::v4(),
            $command->name,
            $command->maxGuests,
            $command->area
        );

        $this->houseRepository->save($house);
    }
}