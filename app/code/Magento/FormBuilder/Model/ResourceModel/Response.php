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

namespace Webkul\FormBuilder\Model\ResourceModel;

class Response extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Function _construct
     */
    protected function _construct()
    {
        $this->_init('wk_form_response', 'entity_id');
    }
}
