<?php

namespace Magento\CustomerLiveChat\Block;
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
        return $this->customerSession->getCustomerId();
    }
}