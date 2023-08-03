<?php
namespace Magento\SellerPartner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SellerPartner extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_entity', 'entity_id');
    }
}
