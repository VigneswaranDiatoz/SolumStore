<?php
namespace Magento\CustomerRFQ\Model;

use Magento\CustomerRFQ\Api\Data\GridInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'magento_customerrfq';

    /**
     * @var string
     */
    protected $_cacheTag = 'magento_customerrfq';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'magento_customerrfq';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Magento\CustomerRFQ\Model\ResourceModel\Grid');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set EntityId.
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set Title.
     */
    public function setCustomerId($email)
    {
        return $this->setData(self::CUSTOMER_ID, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set Title.
     */
    public function setStatus($groupId)
    {
        return $this->setData(self::STATUS, $groupId);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getPartnerId()
    {
        return $this->getData(self::PARTNER_ID);
    }

    /**
     * Set Title.
     */
    public function setPartnerId($isActive)
    {
        return $this->setData(self::PARTNER_ID, $isActive);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getNoOfStore()
    {
        return $this->getData(self::NO_OF_STORES);
    }

    /**
     * Set Title.
     */
    public function setNoOfStore($taxId)
    {
        return $this->setData(self::NO_OF_STORES, $taxId);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getQuantityPerStore()
    {
        return $this->getData(self::QUANTITY_PER_STORE);
    }

    /**
     * Set Title.
     */
    public function setQuantityPerStore($businessName)
    {
        return $this->setData(self::QUANTITY_PER_STORE, $businessName);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * Set Title.
     */
    public function setProductId($email)
    {
        return $this->setData(self::PRODUCT_ID, $email);
    }
    
}