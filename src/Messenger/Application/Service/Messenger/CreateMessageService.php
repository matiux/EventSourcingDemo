<?php

namespace Messenger\Application\Service\Messenger;

use Messenger\Application\Service\ApplicationService;
use Messenger\Domain\Model\Message\Message;
use Messenger\Domain\Model\Message\MessageId;
use Messenger\Domain\Model\Message\MessageRepository;

class CreateMessageService implements ApplicationService
{
    private $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function execute($request = null)
    {
        $subject = $request->getSubject();
        $body = $request->getBody();
        $date = $request->getDateTimeImmutable();

        $m = new Message(
            MessageId::create(),
            $subject,
            $body,
            $date
        );

        $this->messageRepository->add($m);
    }
}
