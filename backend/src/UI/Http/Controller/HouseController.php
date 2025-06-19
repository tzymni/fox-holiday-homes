<?php

namespace App\UI\Http\Controller;

use App\Application\HouseManagement\Command\AddHouseCommand;
use App\Application\HouseManagement\Handler\AddHouseHandler;
use App\Application\HouseManagement\Handler\GetAllHousesQueryHandler;
use App\Application\HouseManagement\Query\GetAllHousesQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HouseController extends AbstractController
{

    /**
     * @param Request $request
     * @param AddHouseHandler $handler
     * @return JsonResponse
     */
    #[Route('/house', name: 'house_add', methods: ['POST'])]
    public function addHouse(Request $request, AddHouseHandler $handler): JsonResponse
    {
        $command = new AddHouseCommand($request->get('name'), $request->get('maxGuests'), $request->get('area'));
        $handler->handle($command);
        return new JsonResponse(['status' => 'ok'], Response::HTTP_CREATED);
    }


    /**
     * @param GetAllHousesQueryHandler $handler
     * @return JsonResponse
     */
    #[Route('/house', name: 'house_list', methods: ['GET'])]
    public function getAllHouses(GetAllHousesQueryHandler $handler): JsonResponse
    {
        $command = new GetAllHousesQuery();
        $houses = $handler($command);
        return new JsonResponse($houses, Response::HTTP_OK);
    }
}