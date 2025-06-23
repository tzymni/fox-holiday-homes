<?php

namespace App\Application\HouseManagement\Handler;

use App\Application\HouseManagement\Command\UpdateHouseCommand;
use App\Domain\HouseManagement\Repository\HouseRepositoryInterface;
use RuntimeException;

readonly class UpdateHouseHandler
{


    public function __construct(private HouseRepositoryInterface $houseRepository)
    {
    }

    /**
     * @param UpdateHouseCommand $command
     * @throws RuntimeException
     * @return void
     */
    public function __invoke(UpdateHouseCommand $command): void
    {
        $house = $this->houseRepository->findById($command->id);

        if (!$house) {
            throw new RuntimeException('House not found');
        }

        if ($command->name !== null) {
            $house->rename($command->name);
        }

        if ($command->maxGuests !== null) {
            $house->changeMaxGuests($command->maxGuests);
        }

        if ($command->area !== null) {
            $house->changeAreaInSquareMeters($command->area);
        }

        $this->houseRepository->save($house);
    }


}