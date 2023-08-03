<?php
namespace Magento\SIPartnerDashboard\Controller\Index;

use Magento\Framework\App\Action\Action;
class Index extends Action
{
    protected $_resultPageFactory;

    public function __construct(
    \Magento\Framework\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    { 
        return $this->_resultPageFactory->create();
    }
}