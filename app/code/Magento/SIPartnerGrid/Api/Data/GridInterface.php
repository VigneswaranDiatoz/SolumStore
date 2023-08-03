<?php
namespace Magento\SIPartnerGrid\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const EMAIL = 'email';

    const GROUP_ID = 'group_id';
    const IS_ACTIVE = 'is_active';
    const TAX_ID = 'tax_id';
    const BUSINESS_NAME = 'business_name';
    const PHONE_NUMBER = 'phone_number';
    const CONTACT_INFO = 'contact_info';
    const ADDRESS = 'address';
    const CREDIT_CARD_INFO = 'credit_card_info';
    const STATE_TAX_ID = 'state_tax_id';
    const ESL = 'esl';
    const SOLUM_PARTNER = 'solum_partner';
    const SALES_SIZE = 'sales_size';
    const CREDIT_RATINGS = 'credit_ratings';
    const BUSINESS_AREA = 'business_area';
    const POS = 'pos';
    const DOCS = 'docs';

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
    public function getEmail();

    /**
     * Set Title.
     */
    public function setEmail($email);
    
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getGroupId();

    /**
     * Set Title.
     */
    public function setGroupId($groupId);
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set Title.
     */
    public function setIsActive($isActive);
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getTaxId();

    /**
     * Set Title.
     */
    public function setTaxId($taxId);
    /**
     * Get Title.
     *
     * @return string|null
     */
    public function getBusinessName();

    /**
     * Set Title.
     */
    public function setBusinessName($businessName);

        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getPhoneNumber();

    /**
     * Set Title.
     */
    public function setPhoneNumber($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getContactInfo();

    /**
     * Set Title.
     */
    public function setContactInfo($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getAddress();

    /**
     * Set Title.
     */
    public function setAddress($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getCreditCardInfo();

    /**
     * Set Title.
     */
    public function setCreditCardInfo($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getStateTaxId();

    /**
     * Set Title.
     */
    public function setStateTaxId($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getEsl();

    /**
     * Set Title.
     */
    public function setEsl($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getSolumPartner();

    /**
     * Set Title.
     */
    public function setSolumPartner($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getSalesSize();

    /**
     * Set Title.
     */
    public function setSalesSize($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getCreditRatings();

    /**
     * Set Title.
     */
    public function setCreditRatings($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getBusinessArea();

    /**
     * Set Title.
     */
    public function setBusinessArea($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getPos();

    /**
     * Set Title.
     */
    public function setPos($email);
        /**
     * Get Title.
     *
     * @return string|null
     */
    public function getDocs();

    /**
     * Set Title.
     */
    public function setDocs($email);
}