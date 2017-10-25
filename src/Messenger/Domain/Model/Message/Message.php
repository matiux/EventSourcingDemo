<?php

namespace Messenger\Domain\Model\Message;

use Messenger\Domain\DomainEventPublisher;
use Messenger\Domain\Model\IdentifiableDomainObject;

class Message implements IdentifiableDomainObject
{
    const DRAFT = 1;
    const SENT = 2;
    const READ = 3;

    private $messageId;
    private $subject;
    private $body;
    private $date;
    private $status;

    public function __construct(MessageId $messageId, $subject, $body, \DateTimeImmutable $date)
    {
        $this->messageId = $messageId;
        $this->subject = $subject;
        $this->body = $body;
        $this->date = $date;
        $this->status = static::DRAFT;

        $this->publishEvent();
    }

    private function publishEvent()
    {
        DomainEventPublisher::instance()->publish(
            new MessageCreated(
                $this->messageId
            )
        );
    }

    public function id()
    {
        return $this->messageId;
    }
}
