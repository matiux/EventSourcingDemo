<?php

namespace Messenger\Domain\Model\Event;

class PublishedMessage
{
    /**
     * @var int
     */
    private $trackerId;

    /**
     * @var string
     */
    private $exchangeName;

    /**
     * @var int
     */
    private $mostRecentPublishedMessageId;

    /**
     * @param string $exchangeName
     * @param int $aMostRecentPublishedMessageId
     */
    public function __construct(string $exchangeName, int $aMostRecentPublishedMessageId)
    {
        $this->exchangeName = $exchangeName;
        $this->mostRecentPublishedMessageId = $aMostRecentPublishedMessageId;
    }

    /**
     * @return int
     */
    public function mostRecentPublishedMessageId(): int
    {
        return $this->mostRecentPublishedMessageId;
    }

    /**
     * @param int $maxId
     */
    public function updateMostRecentPublishedMessageId($maxId)
    {
        $this->mostRecentPublishedMessageId = $maxId;
    }

    /**
     * @return int
     */
    public function trackerId(): int
    {
        return $this->trackerId;
    }
}
