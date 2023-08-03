<?php

namespace Magento\Mymodule\Controller\Index;

use \Magento\Framework\App\Action\HttpGetActionInterface;
use \Magento\Framework\View\Result\PageFactory;
// use \Magento\Customer\Model\Session;
class Index implements HttpGetActionInterface 
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    private $customerSession;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(PageFactory $resultPageFactory) {
        $this->resultPageFactory = $resultPageFactory;
        // $this->customerSession = $customerSession;
    }

    /**
     * Prints the information 
     * @return Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
        // if ($this->customerSession->isLoggedIn()) {
        //     return $this->resultPageFactory->create();
        // } else {
        //     return $this->_redirect('customer/account/login');
        // } 
    }
}