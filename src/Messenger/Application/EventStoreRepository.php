<?php

namespace Messenger\Application;

use Messenger\Domain\DomainEvent;

interface EventStoreRepository
{
    public function append(DomainEvent $aDomainEvent);
    public function allStoredEventsSince($anEventId);
}
