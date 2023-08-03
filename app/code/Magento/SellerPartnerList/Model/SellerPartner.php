<?php
namespace Magento\SellerPartnerList\Model;

use Magento\Framework\Model\AbstractModel;

class SellerPartner extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magento\SellerPartnerList\Model\ResourceModel\SellerPartner');
    }
}
