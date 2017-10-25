<?php

namespace Messenger\Infrastructure\Application\Notification;

use Doctrine\ORM\EntityRepository;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Messenger\Application\EventStoreRepository;
use Messenger\Domain\DomainEvent;
use Messenger\Domain\Model\Event\StoredEvent;

class DoctrineEventStore extends EntityRepository implements EventStoreRepository
{
    private $serializer;

    public function append(DomainEvent $aDomainEvent)
    {
        $serializedEvents = $this->serializer()->serialize($aDomainEvent, 'json');

        $storedEvent = new StoredEvent(
            get_class($aDomainEvent),
            $aDomainEvent->occurredOn(),
            $serializedEvents
        );

        $this->getEntityManager()->persist($storedEvent);
    }

    public function allStoredEventsSince($anEventId)
    {
        $query = $this->createQueryBuilder('e');

        /**
         * Se $anEventId == null, allora il WHERE viene tralasciato e non messo nella query
         */
        if ($anEventId) {
            $query->where('e.eventId > :eventId');
            $query->setParameter('eventId', $anEventId);
        }

        $query->orderBy('e.eventId');

        //$sql = $query->getQuery()->getSQL();

        return $query->getQuery()->getResult();
    }

    private function serializer()
    {
        if (null === $this->serializer) {

            $this->serializer = SerializerBuilder::create()
                ->build();
        }

        return $this->serializer;
    }

    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }
}
