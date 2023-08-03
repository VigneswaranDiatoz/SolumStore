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
     * @var $formBuilder
     */
    protected $formBuilder;
    
    /**
     * __construct
     *
     * @param     \Magento\Backend\Block\Widget\Context         $context
     * @param     \Magento\Framework\View\Result\PageFactory    $resultPageFactory
     * @param     \Magento\Framework\Registry                   $coreRegistry
     * @param     \Webkul\FormBuilder\Model\FormFactory         $formBuilder
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\FormBuilder\Model\FormFactory $formBuilder
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->formBuilder  = $formBuilder;
    }

    /**
     * Function _initAction
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Webkul_Basicsetting::menu');
        return $resultPage;
    }

    /**
     * Function execute
     */
    public function execute()
    {
       
        $id=(int)$this->getRequest()->getParam('entity_id');
       
        $formBuilderModel = $this->formBuilder->create();
        if ($id) {
            if (!$this->check($id)) {
                $this->messageManager->addError(__('This Data no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');

            }
        }

        $this->coreRegistry->register('formDataId', $id);
        $resultPage = $this->_initAction();
        if ($id) {
            $resultPage->getConfig()->getTitle()->prepend(__('Update Data %1', $id));
        } elseif ($id != 0) {
            $resultPage->getConfig()->getTitle()->prepend(__('Add Data'));
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
        return $this->_authorization->isAllowed('Webkul_FormBuilder::form');
    }

    /**
     * Check ID is Exist.
     *
     * @param int $id
     * @return bool
     */
    public function check($id)
    {
        $formBuilder = $this->formBuilder->create();
        $formBuilder = $formBuilder->load($id);
        $details = $formBuilder->getData();
       
        if ($details) {
            return true;
        }
    }
}
