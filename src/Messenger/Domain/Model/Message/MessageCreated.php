<?php

namespace Messenger\Domain\Model\Message;

use Messenger\Domain\DomainEvent;

class MessageCreated implements DomainEvent
{
    private $messageId;
    private $occurredOn;

    public function __construct(MessageId $messageId)
    {
        $this->messageId = $messageId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function messageId()
    {
        return $this->messageId;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
