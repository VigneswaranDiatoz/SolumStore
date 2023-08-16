<?php
namespace  Magento\CustomerRFQ\Model\ResourceModel\Grid;

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
        $this->_init(' Magento\CustomerRFQ\Model\Grid', ' Magento\CustomerRFQ\Model\ResourceModel\Grid');
    }
}