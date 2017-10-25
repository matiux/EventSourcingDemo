<?php

namespace Messenger\Domain\Model\Event;

class StoredEvent
{
    private $eventId;
    private $eventBody;
    private $occurredOn;
    private $typeName;

    public function __construct($aTypeName, \DateTimeImmutable $anOccurredOn, $anEventBody)
    {
        $this->eventBody = $anEventBody;
        $this->typeName = $aTypeName;
        $this->occurredOn = $anOccurredOn;
    }

    public function eventBody()
    {
        return $this->eventBody;
    }

    public function eventId()
    {
        return $this->eventId;
    }

    public function typeName()
    {
        return $this->typeName;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
