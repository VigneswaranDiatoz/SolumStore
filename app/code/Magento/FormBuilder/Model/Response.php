<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_FormBuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\FormBuilder\Model;

use Webkul\FormBuilder\Api\Data\ResponseInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Response extends AbstractModel implements IdentityInterface, ResponseInterface
{
    /**
     * @var string
     */
    public const CACHE_TAG = 'Webkul_formbuilder_res';

    /**
     * @var string
     */
    protected $_cacheTag = 'Webkul_formbuilder_res';

    /**
     * @var string
     */
    protected $_eventPrefix = 'Webkul_formbuilder_res';

     /**
      * Function_construct
      */
    protected function _construct()
    {
        $this->_init(\Webkul\FormBuilder\Model\ResourceModel\Response::class);
    }

    /**
     * Get identities.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set Entity ID
     *
     * @param int $id
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setEntityId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Get Form ID
     *
     * @return int|null
     */
    public function getFormId()
    {
        return $this->getData(self::FORM_ID);
    }

    /**
     * Set Form ID
     *
     * @param int $formId
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setFormId($formId)
    {
        return $this->setData(self::FORM_ID, $formId);
    }

    /**
     * Get User ID
     *
     * @return int|null
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * Set User ID
     *
     * @param int $userId
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Get User ID
     *
     * @return int|null
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * Set User ID
     *
     * @param int $userId
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setStoreId($userId)
    {
        return $this->setData(self::STORE_ID, $userId);
    }

    /**
     * Get User Ip
     *
     * @return string|null
     */
    public function getUserIp()
    {
        return $this->getData(self::USER_IP);
    }

    /**
     * Set User Ip
     *
     * @param string $userIp
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setUserIp($userIp)
    {
        return $this->setData(self::USER_IP, $userIp);
    }

    /**
     * Get Form Response
     *
     * @return string|null
     */
    public function getFormResponse()
    {
        return $this->getData(self::FORM_RESPONSE);
    }

    /**
     * Set Form Response
     *
     * @param string $formResponse
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setFormResponse($formResponse)
    {
        return $this->setData(self::FORM_RESPONSE, $formResponse);
    }
    
    /**
     * Set Created At
     *
     * @param timestamp $createdAt
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get Created At
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set Updated At
     *
     * @param string $updatedAt
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Get Updated At
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }
}
