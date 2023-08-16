<?php
namespace  Magento\AdminRFQ\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(' Magento\AdminRFQ\Model\Grid', ' Magento\AdminRFQ\Model\ResourceModel\Grid');
    }
}