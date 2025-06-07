<?php

namespace App\Infrastructure\HouseManagement\Repository;

use App\Domain\HouseManagement\Entity\House;
use App\Domain\HouseManagement\Repository\HouseRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;

readonly class DoctrineHouseRepository implements HouseRepositoryInterface
{


    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(House $house): void
    {
        $this->entityManager->persist($house);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?House
    {
        try {
            return $this->entityManager->find(House::class, $id);
        } catch (\Exception|ORMException $e) {
            return null;
        }

    }
}