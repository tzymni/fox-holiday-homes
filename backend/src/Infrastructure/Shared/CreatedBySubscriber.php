<?php

namespace App\Infrastructure\Shared;

use App\Domain\UserManagement\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
#[AsDoctrineListener(event: Events::prePersist, priority: 0, connection: 'default')]
class CreatedBySubscriber implements EventSubscriber
{
    public function __construct(private readonly Security $security)
    {
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!property_exists($entity, 'createdBy')) {
            return;
        }

        if (method_exists($entity, 'getCreatedBy') && $entity->getCreatedBy() !== null) {
            return;
        }

        $user = $this->security->getUser();

        if ($user instanceof User && method_exists($entity, 'setCreatedBy')) {
            $entity->setCreatedBy($user);
        }
    }

}


