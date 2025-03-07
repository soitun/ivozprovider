<?php

namespace Ivoz\Provider\Domain\Model\FixedCostsRelInvoiceScheduler;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Model\DtoNormalizer;

/**
 * @codeCoverageIgnore
 */
abstract class FixedCostsRelInvoiceSchedulerDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var string
     */
    private $type = 'static';

    /**
     * @var string
     */
    private $ddisCountryMatch = 'all';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Ivoz\Provider\Domain\Model\FixedCost\FixedCostDto | null
     */
    private $fixedCost;

    /**
     * @var \Ivoz\Provider\Domain\Model\InvoiceScheduler\InvoiceSchedulerDto | null
     */
    private $invoiceScheduler;

    /**
     * @var \Ivoz\Provider\Domain\Model\Country\CountryDto | null
     */
    private $ddisCountry;


    use DtoNormalizer;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
     * @inheritdoc
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'quantity' => 'quantity',
            'type' => 'type',
            'ddisCountryMatch' => 'ddisCountryMatch',
            'id' => 'id',
            'fixedCostId' => 'fixedCost',
            'invoiceSchedulerId' => 'invoiceScheduler',
            'ddisCountryId' => 'ddisCountry'
        ];
    }

    /**
     * @return array
     */
    public function toArray($hideSensitiveData = false)
    {
        $response = [
            'quantity' => $this->getQuantity(),
            'type' => $this->getType(),
            'ddisCountryMatch' => $this->getDdisCountryMatch(),
            'id' => $this->getId(),
            'fixedCost' => $this->getFixedCost(),
            'invoiceScheduler' => $this->getInvoiceScheduler(),
            'ddisCountry' => $this->getDdisCountry()
        ];

        if (!$hideSensitiveData) {
            return $response;
        }

        foreach ($this->sensitiveFields as $sensitiveField) {
            if (!array_key_exists($sensitiveField, $response)) {
                throw new \Exception($sensitiveField . ' field was not found');
            }
            $response[$sensitiveField] = '*****';
        }

        return $response;
    }

    /**
     * @param integer $quantity
     *
     * @return static
     */
    public function setQuantity($quantity = null)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $type
     *
     * @return static
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $ddisCountryMatch
     *
     * @return static
     */
    public function setDdisCountryMatch($ddisCountryMatch = null)
    {
        $this->ddisCountryMatch = $ddisCountryMatch;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getDdisCountryMatch()
    {
        return $this->ddisCountryMatch;
    }

    /**
     * @param integer $id
     *
     * @return static
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\FixedCost\FixedCostDto $fixedCost
     *
     * @return static
     */
    public function setFixedCost(\Ivoz\Provider\Domain\Model\FixedCost\FixedCostDto $fixedCost = null)
    {
        $this->fixedCost = $fixedCost;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\FixedCost\FixedCostDto | null
     */
    public function getFixedCost()
    {
        return $this->fixedCost;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setFixedCostId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\FixedCost\FixedCostDto($id)
            : null;

        return $this->setFixedCost($value);
    }

    /**
     * @return mixed | null
     */
    public function getFixedCostId()
    {
        if ($dto = $this->getFixedCost()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\InvoiceScheduler\InvoiceSchedulerDto $invoiceScheduler
     *
     * @return static
     */
    public function setInvoiceScheduler(\Ivoz\Provider\Domain\Model\InvoiceScheduler\InvoiceSchedulerDto $invoiceScheduler = null)
    {
        $this->invoiceScheduler = $invoiceScheduler;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\InvoiceScheduler\InvoiceSchedulerDto | null
     */
    public function getInvoiceScheduler()
    {
        return $this->invoiceScheduler;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setInvoiceSchedulerId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\InvoiceScheduler\InvoiceSchedulerDto($id)
            : null;

        return $this->setInvoiceScheduler($value);
    }

    /**
     * @return mixed | null
     */
    public function getInvoiceSchedulerId()
    {
        if ($dto = $this->getInvoiceScheduler()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Country\CountryDto $ddisCountry
     *
     * @return static
     */
    public function setDdisCountry(\Ivoz\Provider\Domain\Model\Country\CountryDto $ddisCountry = null)
    {
        $this->ddisCountry = $ddisCountry;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Country\CountryDto | null
     */
    public function getDdisCountry()
    {
        return $this->ddisCountry;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setDdisCountryId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Country\CountryDto($id)
            : null;

        return $this->setDdisCountry($value);
    }

    /**
     * @return mixed | null
     */
    public function getDdisCountryId()
    {
        if ($dto = $this->getDdisCountry()) {
            return $dto->getId();
        }

        return null;
    }
}
