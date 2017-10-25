<?php

namespace Messenger\Domain;

interface DomainEvent
{
    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn();
}
