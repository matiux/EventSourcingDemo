<?php

namespace Messenger\Infrastructure\Application\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Messenger\Application\Service\TransactionalSession;

class DoctrineSession implements TransactionalSession
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function executeAtomically(callable $operation)
    {
        return $this->entityManager->transactional($operation);
    }
}
