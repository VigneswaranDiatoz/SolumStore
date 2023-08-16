<?php

namespace Magento\CustomerRFQ\Block;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;

class Index extends Template
{

    protected $customerSession;
    protected $_contactFactory;

    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,CustomerSession $customerSession) {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function showButton()
    {
        return $this->customerSession->isLoggedIn();
    }
    
    public function getCustomerId()
    {
        // $contact = $this->_contactFactory->create();
        // $collection = $contact->getCollection();
        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        // $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        // $connection = $resource->getConnection();
        // $select = $connection->select()
        //     ->from('customer_entity')
        //     ->where('group_id = 4')
        //     ->where('is_active!=3');
        // $result = $connection->fetchAll($select);
        return $this->customerSession->getCustomerId();
    }
    // public function getCustomerId(){
    //     $objectManager = ObjectManager::getInstance();
    //     $sessionManager = $objectManager->get(\Magento\Framework\Session\SessionManagerInterface::class);
    //     $sessionId = $sessionManager->getSessionId();
    //     return $sessionId;
    // }
}