<?php

namespace DoneSuperApp\Cereal\Laravel;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use DoneSuperApp\Cereal\Contracts\SerializationHandlerFactory as SerializationHandlerFactoryContract;
use DoneSuperApp\Cereal\Laravel\SerializationHandlerFactory as LaravelSerializationHandlerFactory;
use DoneSuperApp\Cereal\SerializationHandlerFactory as BaseSerializationHandlerFactory;

class CerealServiceProvider extends ServiceProvider
{
    /**
     * @throws Exception
     */
    public function boot(): void
    {
        $path = realpath(__DIR__ . '/../../config/cereal.php');
        if (!is_string($path)) {
            throw new Exception('could not load default config');
        }

        $this->publishes([$path => config_path('cereal.php')]);
        $this->mergeConfigFrom($path, 'cereal');

        $handlerFactory = LaravelSerializationHandlerFactory::getInstance();

        $this->app->bind(
            SerializationHandlerFactoryContract::class,
            fn(): SerializationHandlerFactoryContract => $handlerFactory
        );

        $this->app->bind(
            BaseSerializationHandlerFactory::class,
            fn(): SerializationHandlerFactoryContract => $handlerFactory
        );

        $this->app->bind(
            LaravelSerializationHandlerFactory::class,
            fn(): SerializationHandlerFactoryContract => $handlerFactory
        );

        $handlers = $this->config('handlers');
        if (!is_array($handlers)) {
            throw new InvalidArgumentException('invalid handler configuration');
        }

        foreach ($handlers as $type => $handler) {
            $handlerFactory->addHandler($type, $handler);
        }
    }

    /**
     * @param string|null $key
     * @param mixed $default
     *
     * @return Repository|Application|mixed
     */
    private function config(?string $key = null, $default = null)
    {
        $key = $key === null ? '' : ".$key";

        return config('cereal' . $key, $default);
    }
}
