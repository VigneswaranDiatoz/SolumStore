<?php
namespace Magento\SellerPartnerList\Model\ResourceModel\SellerPartner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(
            'Magento\SellerPartnerList\Model\SellerPartner',
            'Magento\SellerPartnerList\Model\ResourceModel\SellerPartner'
        );
    }
}
