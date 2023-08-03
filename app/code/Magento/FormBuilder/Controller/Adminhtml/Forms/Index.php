<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_FormBuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\FormBuilder\Controller\Adminhtml\Forms;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var context
     */
    protected $context;
    
    /**
     * @var $resultPageFactory
     */
    protected $_resultPageFactory;
    
    /**
     * @param    \Magento\Backend\Block\Widget\Context $context
     * @param    \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

     /**
      * Function execute.
      *
      * @return page
      */
    public function execute()
    {
       
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Webkul_FormBuilder::form');
        $resultPage->getConfig()->getTitle()->prepend(__('Forms'));
        return $resultPage;
    }

    /**
     * Check Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_FormBuilder::form');
    }
}
