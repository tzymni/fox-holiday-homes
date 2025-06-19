<?php

namespace App\Application\HouseManagement\Query;

final readonly class GetHouseByIdQuery
{

    public function __construct(public string $id)
    {

    }
}