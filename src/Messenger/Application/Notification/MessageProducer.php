<?php

namespace Messenger\Application\Notification;

interface MessageProducer
{
    public function open($exchangeName);

    public function send(
        string $exchangeName,
        string $notificationMessage,
        string $notificationType,
        int $notificationId,
        \DateTimeInterface $notificationOccurredOn
    );

    public function close($exchangeName);
}
