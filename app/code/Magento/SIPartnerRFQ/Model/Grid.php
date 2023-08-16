<?php
namespace Magento\SIPartnerRFQ\Model;
use \Magento\Framework\DataObject\IdentityInterface;
use \Magento\SIPartnerRFQ\Api\Data\GridInterface;
use \Magento\Framework\Model\AbstractModel;
class Grid extends AbstractModel implements GridInterface,IdentityInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'magento_sipartnerrfq';

    /**
     * @var string
     */
    protected $_cacheTag = 'magento_sipartnerrfq';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'magento_sipartnerrfq';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Magento\SIPartnerRFQ\Model\ResourceModel\Grid');
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
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
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
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
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