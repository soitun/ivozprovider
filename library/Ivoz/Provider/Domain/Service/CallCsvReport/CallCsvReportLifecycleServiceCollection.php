<?php

namespace Ivoz\Provider\Domain\Service\CallCsvReport;

use Ivoz\Core\Domain\Service\LifecycleServiceCollectionInterface;
use Ivoz\Core\Domain\Service\LifecycleServiceCollectionTrait;

/**
 * @codeCoverageIgnore
 */
class CallCsvReportLifecycleServiceCollection implements LifecycleServiceCollectionInterface
{
    use LifecycleServiceCollectionTrait;

    public static $bindedBaseServices = [
        "pre_persist" =>
        [
            \Ivoz\Provider\Domain\Service\CallCsvReport\CsvAttacher::class => 200,
        ],
        "on_commit" =>
        [
            \Ivoz\Provider\Domain\Service\CallCsvReport\EmailSender::class => 300,
        ],
    ];

    /**
     * @return void
     */
    protected function addService(string $event, CallCsvReportLifecycleEventHandlerInterface $service)
    {
        $this->services[$event][] = $service;
    }
}
