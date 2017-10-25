<?php

namespace Messenger\Domain\Model\Message;

class MessageRequest
{
    private $subject;
    private $body;
    private $dateTimeImmutable;

    public function __construct($subject, $body, \DateTimeImmutable $dateTimeImmutable)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->dateTimeImmutable = $dateTimeImmutable;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getDateTimeImmutable()
    {
        return $this->dateTimeImmutable;
    }
}
