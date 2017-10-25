<?php

namespace Messenger\Infrastructure\Domain\Model\Message;

use Messenger\Infrastructure\Domain\Model\DoctrineEntityId;

class DoctrineMessageId extends DoctrineEntityId
{
    public function getName()
    {
        return 'MessageId';
    }
    protected function getNamespace()
    {
        return 'Messenger\Domain\Model\Message';
    }
}
