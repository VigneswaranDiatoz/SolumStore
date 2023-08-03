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

namespace Webkul\FormBuilder\Block\Customer\Widget;

/**
 * @inheritDoc
 */
class Fax extends \Magento\Customer\Block\Widget\Fax
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        parent::_construct();

        // default template location
        $this->setTemplate('Webkul_FormBuilder::customer/widget/fax.phtml');
    }
}
