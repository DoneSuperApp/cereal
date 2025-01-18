<?php

namespace DoneSuperApp\Cereal\Laravel;

use DoneSuperApp\Cereal\Contracts\Serializable;
use DoneSuperApp\Cereal\Serializer;

trait Cereal
{
    use \DoneSuperApp\Cereal\Cereal;

    public function __serialize(): array
    {
        /** @var Serializable $this */
        return [
            $this->getSerializerPropertyName() => new Serializer(
                $this,
                SerializationHandlerFactory::class
            ),
        ];
    }
}