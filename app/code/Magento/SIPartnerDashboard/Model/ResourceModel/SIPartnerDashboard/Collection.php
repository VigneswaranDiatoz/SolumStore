<?php
namespace Magento\SIPartnerDashboard\Model\ResourceModel\SIPartnerDashboard;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(
            'Magento\SIPartnerDashboard\Model\SIPartnerDashboard',
            'Magento\SIPartnerDashboard\Model\ResourceModel\SIPartnerDashboard'
        );
    }
}
