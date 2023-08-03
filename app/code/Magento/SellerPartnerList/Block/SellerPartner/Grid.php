<?php
namespace Magento\SellerPartnerList\Block\SellerPartner;

use Magento\Framework\View\Element\Template;

class Grid extends Template
{
    protected $_sellerCollectionFactory;

    public function __construct(
        Template\Context $context,
        \Magento\SellerPartnerList\Model\ResourceModel\SellerPartner\CollectionFactory $sellerCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_sellerCollectionFactory = $sellerCollectionFactory;
    }

    public function getSellerPartners()
    {
        return $this->_sellerCollectionFactory->create()->getItems();
    }
}
