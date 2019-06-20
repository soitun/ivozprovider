<?php

namespace Ivoz\Provider\Domain\Service\Destination;

use Ivoz\Core\Domain\Service\LifecycleServiceCollectionInterface;
use Ivoz\Core\Domain\Service\LifecycleServiceCollectionTrait;

/**
 * @codeCoverageIgnore
 */
class DestinationLifecycleServiceCollection implements LifecycleServiceCollectionInterface
{
    use LifecycleServiceCollectionTrait;

    public static $bindedBaseServices = [
        "post_persist" =>
        [
            \Ivoz\Cgr\Domain\Service\TpDestination\CreatedByDestination::class => 200,
        ],
        "error_handler" =>
        [
            \Ivoz\Provider\Domain\Service\Destination\PersistErrorHandler::class => 200,
        ],
    ];

    /**
     * @return void
     */
    protected function addService(string $event, DestinationLifecycleEventHandlerInterface $service)
    {
        $this->services[$event][] = $service;
    }
}
