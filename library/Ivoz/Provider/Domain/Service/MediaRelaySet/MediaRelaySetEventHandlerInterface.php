<?php

namespace Ivoz\Provider\Domain\Service\MediaRelaySet;

use Ivoz\Core\Domain\Service\LifecycleEventHandlerInterface;
use Ivoz\Provider\Domain\Model\MediaRelaySet\MediaRelaySetInterface;

interface MediaRelaySetEventHandlerInterface extends LifecycleEventHandlerInterface
{
    public function execute(MediaRelaySetInterface $mediaRelaySet): void;
}
