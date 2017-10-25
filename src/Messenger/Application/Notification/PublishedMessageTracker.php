<?php

namespace Messenger\Application\Notification;

use Messenger\Domain\Model\Event\StoredEvent;

interface PublishedMessageTracker
{
    /**
     * Ritorna l'ID dell'ultimo PublishedMessage così
     * il processo può iniziare dall'ultimo evento.
     *
     * @param string $exchangeName
     * @return int|null
     */
    public function mostRecentPublishedMessageId(string $exchangeName);

    /**
     * E' responsabile di tracciare quale messaggio è statp spedito per ultimo
     * in modo da essere in grado di poterlo ripubblicare in caso di bisogno.
     *
     * @param string $exchangeName
     * @param StoredEvent $notification
     * @return null
     */
    public function trackMostRecentPublishedMessage(string $exchangeName, StoredEvent $notification);
}
