<?php
namespace Magento\SIPartnerRFQ\Model\ResourceModel;
use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Grid Grid mysql resource.
 */
class RFQ extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('product_rfq', 'entity_id'); 
    } 
}