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

class View extends \Magento\Backend\App\Action
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
     * @var $registry
     */
    protected $registry;

    /**
     * @var $helper
     */
    protected $helper;
    
    /**
     * @param     \Magento\Backend\Block\Widget\Context         $context
     * @param     \Magento\Framework\View\Result\PageFactory    $resultPageFactory
     * @param     \Magento\Framework\Registry                   $registry
     * @param     \Webkul\FormBuilder\Helper\Data               $Data
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Webkul\FormBuilder\Helper\Data $Data
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->helper = $Data;
    }

     /**
      * Function execute
      */
    public function execute()
    {
        $entity_id =  $this->getRequest()->getParam('entity_id');
        if (!empty($entity_id) && $this->helper->isResponseExist($entity_id)) {
            $resultPage = $this->_resultPageFactory->create();
            $this->registry->register('entity_id', $entity_id);
            $resultPage->setActiveMenu('Webkul_FormBuilder::response');
            $formName = $this->helper->getFormName($entity_id);
            $resultPage->getConfig()->getTitle()->prepend(__('Response of %1 #%2', $formName, $entity_id));
            return $resultPage;
        } else {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('*/*/index/');
        }
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
