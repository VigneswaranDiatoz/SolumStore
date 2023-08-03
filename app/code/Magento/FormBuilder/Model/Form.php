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

class Form extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    public const CACHE_TAG = 'Webkul_formbuilder_form';
    
    /**
     * @var string
     */
    protected $_cacheTag = 'Webkul_formbuilder_form';

    /**
     * @var string
     */
    protected $_eventPrefix = 'Webkul_formbuilder_form';

    /**
     * Function _construct
     */
    protected function _construct()
    {
        $this->_init(\Webkul\FormBuilder\Model\ResourceModel\Form::class);
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
     * Get Default Values.
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
