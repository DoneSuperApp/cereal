<?php

namespace DoneSuperApp\Cereal\Laravel;

use DoneSuperApp\Cereal\Contracts\SerializationHandler;
use DoneSuperApp\Cereal\DefaultSerializationHandler;
use DoneSuperApp\Cereal\SerializationHandlerFactory as BaseSerializationHandlerFactory;

class SerializationHandlerFactory extends BaseSerializationHandlerFactory
{
    public function getHandler(string $type): SerializationHandler
    {
        $handler = parent::getHandler($type);
        if (!$handler instanceof DefaultSerializationHandler) {
            return $handler;
        }

        if (is_subclass_of($type, \Illuminate\Database\Eloquent\Model::class)) {
            return new ModelSerializationHandler();
        }

        return $handler;
    }
}
