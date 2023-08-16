<?php

namespace Magento\SIPartnerRFQ\Block;
use Magento\SIPartnerRFQ\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session as CustomerSession;

class Index extends Template
{
    protected $_contactFactory;
    protected $customerSession;
    public function __construct(
    Template\Context $context,
    CollectionFactory $contactFactory,CustomerSession $customerSession
    
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context);
        $this->_contactFactory = $contactFactory;
    }

    public function getData($key = '', $index = NULL)
    {
        // $viewCollection = $this->_contactFactory ->create();
        // $viewCollection->addFieldToSelect('*')->load();
        // var_dump($viewCollection->getItems());die();
        // return $viewCollection->getItems();
        $user_id=$this->customerSession->getCustomerId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $select = $connection->select()
            ->from('product_rfq')
            ->where("partner_id = $user_id");
            // ->where('is_active!=3');
        $result = $connection->fetchAll($select);
        return $result;
    }

    // public function getData($key = '', $index = null)
    // {
    //     $contact = $this->_contactFactory->create();
    //     $collection = $contact->getData();
    //     return $collection;
    // }
}