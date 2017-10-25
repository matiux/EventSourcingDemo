<?php

namespace Messenger\Domain\Model\Message;

interface MessageRepository
{
    public function ofId(MessageId $messageId);
    public function ofSubject(string $subject);
    public function add(Message $message);
    public function nextIdentity();
}
