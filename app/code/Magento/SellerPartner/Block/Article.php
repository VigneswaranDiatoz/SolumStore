<?php
namespace Magento\SellerPartner\Block;

use Magento\Framework\View\Element\Template;

class Article extends Template
{
    protected $_sellerCollectionFactory;

    public function __construct(
        Template\Context $context,
        \Magento\SellerPartner\Model\ResourceModel\SellerPartner\CollectionFactory $sellerCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_sellerCollectionFactory = $sellerCollectionFactory;
    }

    public function getSellerPartners()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
    $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
    $connection = $resource->getConnection();
    $select = $connection->select()
        ->from('customer_entity')
        ->where('group_id = 4')
        ->where('is_active=1');

    $result = $connection->fetchAll($select);
        return $result;
    }
}
