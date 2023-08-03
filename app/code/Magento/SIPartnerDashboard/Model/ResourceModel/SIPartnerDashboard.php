<?php
namespace Magento\SIPartnerDashboard\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SIPartnerDashboard extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_entity', 'entity_id');
    }
}
