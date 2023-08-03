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

namespace Webkul\FormBuilder\Api\Data;

interface ResponseInterface
{
    public const ENTITY_ID            =  'entity_id';
    public const FORM_ID              =  'form_id';
    public const USER_ID              =  'user_id';
    public const STORE_ID             =  'store_id';
    public const USER_IP              =  'user_ip';
    public const FORM_RESPONSE        =  'forms_response';
    public const CREATED_AT           =  'created_at';
    public const UPDATED_AT           =  'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Get Form Id
     *
     * @return int|null
     */
    public function getFormId();

    /**
     * Get User Id
     *
     * @return int|null
     */
    public function getUserId();

    /**
     * Get Store Id
     *
     * @return int|null
     */
    public function getStoreId();

    /**
     * Get User Ip
     *
     * @return string|null
     */
    public function getUserIp();

    /**
     * Get Form Response
     *
     * @return string|null
     */
    public function getFormResponse();

    /**
     * Get Created at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get Updated at
     *
     * @return string|null
     */
    public function getUpdatedAt();
    
    /**
     * Set ID
     *
     * @param int $id
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setEntityId($id);

    /**
     * Set Form Id
     *
     * @param int $formId
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setFormId($formId);

    /**
     * Set User Id
     *
     * @param int $userId
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setUserId($userId);

    /**
     * Set Store Id
     *
     * @param int $storeId
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setStoreId($storeId);

    /**
     * Set User Ip
     *
     * @param string $userIp
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setUserIp($userIp);

    /**
     * Set Form Response
     *
     * @param string $formResponse
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setFormResponse($formResponse);

    /**
     * Set Created at
     *
     * @param string $createdAt
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Set Updated at
     *
     * @param string $updatedAt
     * @return Webkul\FormBuilder\Api\Data\ResponseInterface
     */
    public function setUpdatedAt($updatedAt);
}
