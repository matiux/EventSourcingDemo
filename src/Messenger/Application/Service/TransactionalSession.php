<?php

namespace Messenger\Application\Service;

interface TransactionalSession
{
    public function executeAtomically(callable $operation);
}
