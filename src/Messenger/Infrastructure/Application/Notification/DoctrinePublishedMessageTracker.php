<?php

namespace Messenger\Infrastructure\Application\Notification;

use Doctrine\ORM\EntityRepository;
use Messenger\Application\Notification\PublishedMessageTracker;
use Messenger\Domain\Model\Event\PublishedMessage;
use Messenger\Domain\Model\Event\StoredEvent;

/**
 * Class DoctrinePublishedMessageTracker
 * @package Messenger\Infrastructure\Application\Notification
 *
 * TODO
 * The only edge case we have to consider is when no Domain Event has been published already.
 */
class DoctrinePublishedMessageTracker extends EntityRepository implements PublishedMessageTracker
{
    /**
     * TODO
     * Q. e se per qualche motivo non fossero in ordine e mi tornasse un id sbagliato?
     * A. In realtà questo repository contine un solo record, che rappresenta l'ultimo evento pubblicato
     *
     * Ritorna l'ID dell'ultimo PublishedMessage così il processo può iniziare dall'ultimo evento.
     *
     * @param string $exchangeName
     * @return int|null
     */
    public function mostRecentPublishedMessageId(string $exchangeName)
    {
        /** @var $messageTracked PublishedMessage */
        $messageTracked = $this->findOneByExchangeName($exchangeName);

        if (!$messageTracked) {

            return null;
        }

        return $messageTracked->mostRecentPublishedMessageId();
    }

    /**
     * E' responsabile di tracciare quale messaggio è statp spedito per ultimo
     * in modo da essere in grado di poterlo ripubblicare in caso di bisogno.
     *
     * @param string $exchangeName
     * @param StoredEvent $notification
     * @return null
     */
    public function trackMostRecentPublishedMessage(string $exchangeName, StoredEvent $notification)
    {
        if (!$notification) {

            return null;
        }

        $maxId = $notification->eventId();

        $publishedMessage = $this->findOneByExchangeName($exchangeName);

        if (null === $publishedMessage) {

            $publishedMessage = new PublishedMessage(
                $exchangeName,
                $maxId
            );
        }

        $publishedMessage->updateMostRecentPublishedMessageId($maxId);

        $this->getEntityManager()->persist($publishedMessage);

        $this->getEntityManager()->flush($publishedMessage);
    }
}
