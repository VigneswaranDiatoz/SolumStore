<?php
namespace Magento\CustomerRFQ\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';

    const CUSTOMER_ID = 'customer_id';
    const STATUS = 'status';
    const PARTNER_ID = 'partner_id';
    const NO_OF_STORES = 'no_of_stores';
    const QUANTITY_PER_STORE = 'quantity_per_store';
    const PRODUCT_ID = 'product_id';

    /**
     * Get ArticleId.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set ArticleId.
     */
    public function setEntityId($entityId);

    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set Title.
     */
    public function setCustomerId($email);
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Set Title.
     */
    public function setStatus($groupId);
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getPartnerId();

    /**
     * Set Title.
     */
    public function setPartnerId($isActive);
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getNoOfStore();

    /**
     * Set Title.
     */
    public function setNoOfStore($taxId);
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getQuantityPerStore();

    /**
     * Set Title.
     */
    public function setQuantityPerStore($businessName);

        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getProductId();

    /**
     * Set Title.
     */
    public function setProductId($email);
      
}