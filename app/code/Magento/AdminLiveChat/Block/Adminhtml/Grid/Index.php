<?php

namespace Magento\AdminLiveChat\Block\Adminhtml\Grid;
use Magento\Customer\Model\Session as CustomerSession;
// use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template;

use Magento\Backend\Model\Auth\Session as AdminSession;

class Index extends Template
{

    protected $adminSession;
    protected $_contactFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,AdminSession $adminSession) {
        $this->adminSession = $adminSession;
        parent::__construct($context);
    }

    public function showButton()
    {
        return $this->adminSession->isLoggedIn();
    }
    
    public function getAdminId()
    {
        return $this->adminSession->getUser()->getId();
    }
    // public function getCustomerId(){
    //     $objectManager = ObjectManager::getInstance();
    //     $sessionManager = $objectManager->get(\Magento\Framework\Session\SessionManagerInterface::class);
    //     $sessionId = $sessionManager->getSessionId();
    //     return $sessionId;
    // }
}