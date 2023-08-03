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
namespace Webkul\FormBuilder\Controller\Adminhtml\Response;

use Magento\Framework\Controller\ResultFactory;

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
     * @var $helper
     */
    protected $helper;
    
    /**
     * @param     \Magento\Backend\Block\Widget\Context $context
     * @param     \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param     \Webkul\FormBuilder\Helper\Data $Data
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Webkul\FormBuilder\Helper\Data $Data
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->helper = $Data;
    }

     /**
      * Function execute
      */
    public function execute()
    {
        
        $form_id =  $this->getRequest()->getParam('form_id');
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Webkul_FormBuilder::response');
       
        if (!isset($form_id)) {
            $resultPage->getConfig()->getTitle()->prepend(__('All Responses'));
        } else {
            // if(!$this->helper->isResponseByFormIDExist($form_id)){
            //     /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            //     $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            //     return $resultRedirect->setPath('*/*/index/');
            // }
            $formName = $this->helper->getFormNameById($form_id);
            $resultPage->getConfig()->getTitle()->prepend(__('Response of %1', $formName));
        }
    
        return $resultPage;
    }

    /**
     * Check Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_FormBuilder::response');
    }
}
