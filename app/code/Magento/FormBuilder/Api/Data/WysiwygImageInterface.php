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

interface WysiwygImageInterface
{
    public const ENTITY_ID   = 'entity_id';
    public const USER_ID   = 'user_id';
    public const URL         = 'url';
    public const NAME        = 'name';
    public const TYPE        = 'type';
    public const FILE        = 'file';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Get User Id
     *
     * @return int|null
     */
    public function getUserId();

    /**
     * Get Url
     *
     * @return string|null
     */
    public function getUrl();

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get Type
     *
     * @return string|null
     */
    public function getType();

    /**
     * Get File
     *
     * @return string|null
     */
    public function getFile();

    /**
     * Set ID
     *
     * @param int $id
     * @return int|null
     */
    public function setEntityId($id);

    /**
     * Set User Id
     *
     * @param int $userId
     * @return int|null
     */
    public function setUserId($userId);

    /**
     * Set Url
     *
     * @param string $url
     * @return string|null
     */
    public function setUrl($url);

    /**
     * Set Name
     *
     * @param string $name
     * @return string|null
     */
    public function setName($name);

    /**
     * Set Type
     *
     * @param string $type
     * @return string|null
     */
    public function setType($type);

    /**
     * Set File
     *
     * @param string $file
     * @return string|null
     */
    public function setFile($file);
}
