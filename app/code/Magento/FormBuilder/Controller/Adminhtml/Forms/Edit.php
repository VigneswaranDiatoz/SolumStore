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

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var context
     */
    protected $context;
    
    /**
     * @var $coreRegistry
     */
    public $coreRegistry;
    
    /**
     * @var $formBuilder
     */
    public $formBuilder;

    /**
     * @var $resultPageFactory
     */
    protected $resultPageFactory;
    
    /**
     * __construct
     *
     * @param    \Magento\Backend\Block\Widget\Context          $context
     * @param    \Magento\Framework\Registry                    $coreRegistry
     * @param    \Webkul\FormBuilder\Model\FormFactory          $formBuilder
     * @param    \Magento\Framework\View\Result\PageFactory     $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\FormBuilder\Model\FormFactory $formBuilder,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->formBuilder  = $formBuilder;
        $this->resultPageFactory = $resultPageFactory;
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
            $resultPage->getConfig()->getTitle()->prepend(__('Update Form #%1', $id));
        } elseif ($id != 0) {
            $resultPage->getConfig()->getTitle()->prepend(__('Add Form'));
        }
        return $resultPage;
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
