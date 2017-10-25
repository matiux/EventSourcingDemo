<?php

namespace Messenger\Application\Notification;

use JMS\Serializer\SerializerBuilder;
use Messenger\Application\EventStoreRepository;
use Messenger\Domain\Model\Event\StoredEvent;

class NotificationService
{
    private $eventStore;
    private $publishedMessageTracker;
    private $messageProducer;
    private $serializer;

    public function __construct
    (
        EventStoreRepository $eventStore,
        PublishedMessageTracker $publishedMessageTracker,
        MessageProducer $messageProducer
    )
    {

        $this->eventStore = $eventStore;
        $this->publishedMessageTracker = $publishedMessageTracker;
        $this->messageProducer = $messageProducer;
    }

    public function publishNotifications($exchangeName)
    {
        /**
         * Contiene tutti gli eventi non ancora pubblicati presi da EventStore,
         * partendo dall'id dell'ultimo evento pubblicato (quello più recente per intenderci)
         */
        $notifications = $this->listUnpublishedNotifications(
            $this->publishedMessageTracker->mostRecentPublishedMessageId($exchangeName)
        );

        if (!$notifications) {

            return 0;
        }

        $this->messageProducer->open($exchangeName);

        try {

            $publishedMessages = 0;
            $lastPublishedNotification = null;

            foreach ($notifications as $notification) {

                $lastPublishedNotification = $this->publish(
                    $exchangeName,
                    $notification,
                    $this->messageProducer
                );

                $publishedMessages++;
            }

        } catch(\Exception $e) {

            throw $e;
        }

        $this->publishedMessageTracker->trackMostRecentPublishedMessage($exchangeName, $lastPublishedNotification);

        $this->messageProducer->close($exchangeName);

        return $publishedMessages;
    }

    private function listUnpublishedNotifications($mostRecentPublishedMessageId)
    {
        return $this->eventStore->allStoredEventsSince($mostRecentPublishedMessageId);
    }

    private function publish($exchangeName, StoredEvent $notification, MessageProducer $messageProducer)
    {
        $serialized = $this->serializer()->serialize($notification, 'json');

        $messageProducer->send(
            $exchangeName,
            $serialized,
            $notification->typeName(),
            $notification->eventId(),
            $notification->occurredOn()
        );

        return $notification;
    }

    private function serializer()
    {
        if (null === $this->serializer) {

            $this->serializer = SerializerBuilder::create()->build();
        }

        return $this->serializer;
    }
}
