<?php
namespace Magento\AdminLiveChat\Controller\Adminhtml\Grid;
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) 
    {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * Grid List page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        // var_dump("fgd fdf");die();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__('Customer Chat List')));
        
		return $resultPage;
    }

    /**
     * Check Grid List Permission.
     *
     * @return bool
     */
    // public function getCustomerById($customerId)
    // {
    //     $customer = $this->customerFactory->create()->load($customerId);
    //     $imagePath = $customer->getCustomAttribute('profile_picture'); // Replace with your actual attribute code

    //     if ($imagePath) {
    //         return $imagePath->getValue();
    //     }

    //     return null;
    // }
    protected function _isAllowed()
    {
        
        return $this->_authorization->isAllowed('Magento_AdminLiveChat::grid_list');
    }
}