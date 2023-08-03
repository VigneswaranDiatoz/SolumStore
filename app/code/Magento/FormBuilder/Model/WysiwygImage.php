<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_FromBuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\FormBuilder\Model;

use Webkul\FormBuilder\Api\Data\WysiwygImageInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class WysiwygImage extends AbstractModel implements WysiwygImageInterface, IdentityInterface
{
    public const CACHE_TAG = 'formbuilder_wysiwygimage';
    
    /**
     * @var string
     */
    protected $_cacheTag = 'formbuilder_wysiwygimage';
    
    /**
     * @var string
     */
    
    protected $_eventPrefix = 'formbuilder_wysiwygimage';

    /**
     * Function _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Webkul\FormBuilder\Model\ResourceModel\WysiwygImage::class
        );
    }

    /**
     * Function getIdentities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getEntityId()];
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
     * Set Id
     *
     * @param int $id
     * @return void
     */
    public function setEntityId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
    
    /**
     * Get User Id
     *
     * @return int|null
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }
    /**
     * Set User Id
     *
     * @param int $userId

     * @return void
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }
    
    /**
     * Get Url
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->getData(self::URL);
    }

    /**
     * Set Url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get Type
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * Set Type
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }
    /**
     * Get File
     *
     * @return string|null
     */
    public function getFile()
    {
        return $this->getData(self::FILE);
    }

    /**
     * Set File
     *
     * @param string $file
     * @return void
     */
    public function setFile($file)
    {
        return $this->setData(self::FILE, $file);
    }
}
