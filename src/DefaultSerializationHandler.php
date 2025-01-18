<?php

namespace DoneSuperApp\Cereal;

use DoneSuperApp\Cereal\Contracts\Serializable;
use DoneSuperApp\Cereal\Contracts\SerializationHandler;

class DefaultSerializationHandler implements SerializationHandler
{
    /**
     * @param mixed $value
     *
     */
    public function serialize(Serializable $serializable, $value): string
    {
        return serialize($value);
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function deserialize(Serializable $serializable, $value)
    {
        return unserialize($value);
    }
}
