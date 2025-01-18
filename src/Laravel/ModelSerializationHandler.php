<?php

namespace DoneSuperApp\Cereal\Laravel;

use Illuminate\Contracts\Database\ModelIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesAndRestoresModelIdentifiers;
use DoneSuperApp\Cereal\Contracts\Serializable;
use DoneSuperApp\Cereal\Contracts\SerializationHandler;

final class ModelSerializationHandler implements SerializationHandler
{
    use SerializesAndRestoresModelIdentifiers;

    /**
     * @param Model $value
     *
     * @return ModelIdentifier|mixed
     */
    public function serialize(Serializable $serializable, $value)
    {
        return $this->getSerializedPropertyValue($value);
    }

    /**
     * @param ModelIdentifier|mixed $value
     *
     * @return mixed
     */
    public function deserialize(Serializable $serializable, $value)
    {
        return $this->getRestoredPropertyValue($value);
    }
}
