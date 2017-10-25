<?php

namespace Messenger\Infrastructure\Application\Notification;

use Messenger\Application\Notification\MessageProducer;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqMessageProducer extends RabbitMqMessaging implements MessageProducer
{
    /**
     * @param $exchangeName
     * @param string $notificationMessage
     * @param string $notificationType
     * @param int $notificationId
     * @param \DateTimeInterface $notificationOccurredOn
     */
    public function send(
        string $exchangeName,
        string $notificationMessage,
        string $notificationType,
        int $notificationId,
        \DateTimeInterface $notificationOccurredOn
    )
    {
        $amqpMessage = new AMQPMessage(
            $notificationMessage,
            [
                'type' => $notificationType,
                'timestamp' => $notificationOccurredOn->getTimestamp(),
                'message_id' => $notificationId,
                'delivery_mode' => 2 // make message persistent
            ]
        );

        $this->channel($exchangeName)->basic_publish(
            $amqpMessage,
            $exchangeName
        );
    }
}
