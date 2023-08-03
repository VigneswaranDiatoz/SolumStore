<?php
namespace Magento\SIPartnerGrid\Model;

use Magento\SIPartnerGrid\Api\Data\GridInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'magento_sipartnergrid';

    /**
     * @var string
     */
    protected $_cacheTag = 'magento_sipartnergrid';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'magento_sipartnergrid';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Magento\SIPartnerGrid\Model\ResourceModel\Grid');
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
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set Title.
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getGroupId()
    {
        return $this->getData(self::GROUP_ID);
    }

    /**
     * Set Title.
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set Title.
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getTaxId()
    {
        return $this->getData(self::TAX_ID);
    }

    /**
     * Set Title.
     */
    public function setTaxId($taxId)
    {
        return $this->setData(self::TAX_ID, $taxId);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getBusinessName()
    {
        return $this->getData(self::BUSINESS_NAME);
    }

    /**
     * Set Title.
     */
    public function setBusinessName($businessName)
    {
        return $this->setData(self::BUSINESS_NAME, $businessName);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->getData(self::PHONE_NUMBER);
    }

    /**
     * Set Title.
     */
    public function setPhoneNumber($email)
    {
        return $this->setData(self::PHONE_NUMBER, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getContactInfo()
    {
        return $this->getData(self::CONTACT_INFO);
    }

    /**
     * Set Title.
     */
    public function setContactInfo($email)
    {
        return $this->setData(self::CONTACT_INFO, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * Set Title.
     */
    public function setAddress($email)
    {
        return $this->setData(self::ADDRESS, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getCreditCardInfo()
    {
        return $this->getData(self::CREDIT_CARD_INFO);
    }

    /**
     * Set Title.
     */
    public function setCreditCardInfo($email)
    {
        return $this->setData(self::CREDIT_CARD_INFO, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getStateTaxId()
    {
        return $this->getData(self::STATE_TAX_ID);
    }

    /**
     * Set Title.
     */
    public function setStateTaxId($email)
    {
        return $this->setData(self::STATE_TAX_ID, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getEsl()
    {
        return $this->getData(self::ESL);
    }

    /**
     * Set Title.
     */
    public function setEsl($email)
    {
        return $this->setData(self::ESL, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getSolumPartner()
    {
        return $this->getData(self::SOLUM_PARTNER);
    }

    /**
     * Set Title.
     */
    public function setSolumPartner($email)
    {
        return $this->setData(self::SOLUM_PARTNER, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getSalesSize()
    {
        return $this->getData(self::SALES_SIZE);
    }

    /**
     * Set Title.
     */
    public function setSalesSize($email)
    {
        return $this->setData(self::SALES_SIZE, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getCreditRatings()
    {
        return $this->getData(self::CREDIT_RATINGS);
    }

    /**
     * Set Title.
     */
    public function setCreditRatings($email)
    {
        return $this->setData(self::CREDIT_RATINGS, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getBusinessArea()
    {
        return $this->getData(self::BUSINESS_AREA);
    }

    /**
     * Set Title.
     */
    public function setBusinessArea($email)
    {
        return $this->setData(self::BUSINESS_AREA, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getPos()
    {
        return $this->getData(self::POS);
    }

    /**
     * Set Title.
     */
    public function setPos($email)
    {
        return $this->setData(self::POS, $email);
    }
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getDocs()
    {
        return $this->getData(self::DOCS);
    }

    /**
     * Set Title.
     */
    public function setDocs($email)
    {
        return $this->setData(self::DOCS, $email);
    }
}