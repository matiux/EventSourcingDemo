<?php

namespace Messenger\Infrastructure\Domain\Model\Message;

use Doctrine\ORM\EntityRepository;
use Messenger\Domain\Model\Message\Message;
use Messenger\Domain\Model\Message\MessageId;
use Messenger\Domain\Model\Message\MessageRepository;

class DoctrineMessageRepository extends EntityRepository implements MessageRepository
{
    public function ofId(MessageId $messageId)
    {
        return $this->find($messageId);
    }

    public function ofSubject(string $subject)
    {
        return $this->findOneBy(['subject' => $subject]);
    }

    public function add(Message $message)
    {
        $this->getEntityManager()->persist($message);
    }

    public function nextIdentity()
    {
        return MessageId::create();
    }
}
