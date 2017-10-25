<?php

namespace Messenger\Domain\Model;

use Ramsey\Uuid\Uuid;

abstract class EntityId
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $anId
     */
    private function __construct($anId = null)
    {
        $this->verifyInputId($anId);

        $this->id = $anId ?: Uuid::uuid4()->toString();
    }

    public static function create($anId = null)
    {
        return new static($anId);
    }

    public function get(): string
    {
        return $this->id;
    }

    /**
     * @param EntityId $entityId
     *
     * @return bool
     */
    public function equals(EntityId $entityId): bool
    {
        return $this->get() === $entityId->get();
    }

    private function verifyInputId($anId)
    {
        if (is_object($anId)) {
            throw new \InvalidArgumentException("Entity id input must be scalar type");
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->get();
    }
}
