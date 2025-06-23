<?php

namespace App\UI\Http\Controller;

use App\Application\HouseManagement\Command\{AddHouseCommand, UpdateHouseCommand};
use App\Application\HouseManagement\Handler\{AddHouseHandler,
    GetAllHousesQueryHandler,
    GetHouseByIdQueryHandler,
    UpdateHouseHandler
};
use Exception;
use App\Application\HouseManagement\Query\{GetAllHousesQuery, GetHouseByIdQuery};
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
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
        try {
            $command = new AddHouseCommand($request->get('name'), $request->get('maxGuests'), $request->get('area'));
            $handler->handle($command);
            return new JsonResponse(['status' => 'ok'], Response::HTTP_CREATED);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param UpdateHouseHandler $handler
     * @return JsonResponse
     */
    #[Route('/house/{id}', name: 'house_edit', methods: ['PATCH'])]
    public function updateHouse(Request $request, UpdateHouseHandler $handler): JsonResponse
    {
        try {
            $command = new UpdateHouseCommand(
                $request->get('id'),
                $request->get('name'),
                $request->get('maxGuests'),
                $request->get('area')
            );

            $handler($command);
            return new JsonResponse(['status' => 'ok'], Response::HTTP_OK);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param GetAllHousesQueryHandler $handler
     * @return JsonResponse
     */
    #[Route('/house', name: 'house_list', methods: ['GET'])]
    public function getAllHouses(GetAllHousesQueryHandler $handler): JsonResponse
    {
        try {
            $command = new GetAllHousesQuery();
            $houses = $handler($command);
            return new JsonResponse($houses, Response::HTTP_OK);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param GetHouseByIdQueryHandler $handler
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/house/{id}', name: 'house_show', methods: ['GET'])]
    public function getHouseById(GetHouseByIdQueryHandler $handler, string $id): JsonResponse
    {
        try {
            $command = new GetHouseByIdQuery($id);
            $house = $handler($command);
            return new JsonResponse($house, Response::HTTP_OK);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}