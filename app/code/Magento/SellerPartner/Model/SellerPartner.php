<?php
namespace Magento\SellerPartner\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\SellerPartner\Model\ResourceModel\SellerPartner\Collection;
class SellerPartner extends AbstractModel
{
    protected $sellerCollectionFactory;
    protected function _construct(Collection $sellerCollectionFactory)
    {
        // $this->_init('Magento\SellerPartner\Model\ResourceModel\SellerPartner');
        $this->sellerCollectionFactory = $sellerCollectionFactory;
        parent::__construct();
    }
    public function getActiveSellers()
    {
        $sellerCollection = $this->sellerCollectionFactory->create();
        $sellerCollection->addFieldToFilter('group_id', ['eq' => '3']);

        return $sellerCollection;
    }
}
