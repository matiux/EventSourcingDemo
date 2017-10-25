<?php

namespace Messenger\Infrastructure\Application\Notification;

use Aws\Sqs\SqsClient;
use Messenger\Application\Notification\MessageProducer;

class AmazonSqsMessageProducer implements MessageProducer
{
    /**
     * @var SqsClient
     */
    private $client;

    public function open($exchangeName)
    {
        $this->client = new SqsClient([
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' => [
                'key' => getenv('AMAZON_SQS_KEY'),
                'secret' => getenv('AMAZON_SQS_SECRET'),
            ],
        ]);
    }

    public function send(
        string $exchangeName,
        string $notificationMessage,
        string $notificationType,
        int $notificationId,
        \DateTimeInterface $notificationOccurredOn
    )
    {
        $result = $this->client->sendMessage([
            'QueueUrl' => getenv('AMAZON_SQS_QUEUE_URL'),
            'MessageBody' => $notificationMessage,
        ]);
    }

    public function close($exchangeName)
    {

    }
}
