<?php

namespace Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelMatchlist;

class ConditionalRoutesConditionsRelMatchlist extends ConditionalRoutesConditionsRelMatchlistAbstract implements ConditionalRoutesConditionsRelMatchlistInterface
{
    use ConditionalRoutesConditionsRelMatchlistTrait;

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet(): array
    {
        return parent::getChangeSet();
    }


    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
