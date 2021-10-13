<?php

namespace Ivoz\Provider\Domain\Model\BalanceNotification;

/**
 * BalanceNotification
 */
class BalanceNotification extends BalanceNotificationAbstract implements BalanceNotificationInterface
{
    use BalanceNotificationTrait;

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

    protected function sanitizeValues()
    {
        /**
         * @todo ensure carrier or company to have value
         */
        if ($this->getCarrier()) {
            $this->setCompany(null);
        }
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Language\LanguageInterface | null
     */
    public function getLanguage()
    {
        $carrier = $this->getCarrier();
        if ($carrier) {
            return $carrier
                ->getBrand()
                ->getLanguage();
        }

        $company = $this->getCompany();
        $language = $company
            ? $company->getLanguage()
            : null;

        if (!$language && $company) {

            /**
             * @todo remove this. Company will already have brand language
             * @see Company::sanitizeValues()
             */
            $language = $company
                ->getBrand()
                ->getLanguage();
        }

        return $language;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        $carrier = $this->getCarrier();
        if ($carrier) {
            return $carrier->getName();
        }

        return $this
            ->getCompany()
            ->getName();
    }
}
