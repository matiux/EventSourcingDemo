<?php

namespace Messenger\Domain;

class DomainEventPublisher
{
    private $subscribers;

    private static $instance = null;

    /**
     * @return DomainEventPublisher
     */
    public static function instance()
    {
        if (null === static::$instance) {

            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }

    public function subscribe(DomainEventSubscriber $aDomainEventSubscribe)
    {
        $this->subscribers[] = $aDomainEventSubscribe;
    }

    public function publish(DomainEvent $anEvent)
    {
        foreach ($this->subscribers as $aSubscriber) {

            if ($aSubscriber->isSubscribedTo($anEvent)) {
                $aSubscriber->handle($anEvent);
            }
        }
    }
}
