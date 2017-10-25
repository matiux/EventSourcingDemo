<?php

namespace Messenger\Domain\Subscriber;

use Messenger\Application\EventStoreRepository;
use Messenger\Domain\DomainEvent;
use Messenger\Domain\DomainEventSubscriber;

class PersistAllDomainEventSubscriber implements DomainEventSubscriber
{
    private $eventStore;

    public function __construct(EventStoreRepository $anEventStore)
    {
        $this->eventStore = $anEventStore;
    }

    /**
     * @param DomainEvent $aDomainEvent
     */
    public function handle($aDomainEvent)
    {
        $this->eventStore->append($aDomainEvent);
    }

    /**
     * @param DomainEvent $aDomainEvent
     * @return bool
     */
    public function isSubscribedTo($aDomainEvent)
    {
        return true;
    }
}
