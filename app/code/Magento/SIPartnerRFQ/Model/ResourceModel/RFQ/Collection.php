<?php
namespace  Magento\SIPartnerRFQ\Model\ResourceModel\RFQ;

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
        $this->_init(\Magento\SIPartnerRFQ\Model\RFQ::class,\Magento\SIPartnerRFQ\Model\ResourceModel\RFQ::class);
    }
}