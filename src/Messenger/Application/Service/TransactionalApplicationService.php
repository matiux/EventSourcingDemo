<?php

namespace Messenger\Application\Service;

class TransactionalApplicationService implements ApplicationService
{
    private $applicationService;
    private $session;

    public function __construct(ApplicationService $applicationService, TransactionalSession $session)
    {
        $this->applicationService = $applicationService;
        $this->session = $session;
    }

    public function execute($request = null)
    {
        $operation = function() use ($request) {

            return $this->applicationService->execute($request);
        };

        return $this->session->executeAtomically($operation);
    }
}
