<?php
namespace Magento\SIPartnerRFQ\Model;
use \Magento\Framework\DataObject\IdentityInterface;
use Magento\SIPartnerRFQ\Api\Data\RFQInterface;
use Magento\SIPartnerRFQ\Model\ResourceModel\RFQ as RFQResourceModel;
use \Magento\Framework\Model\AbstractModel;
class RFQ extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(RFQResourceModel::class);
    }
       
}