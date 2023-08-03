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

class Save extends \Magento\Backend\App\Action
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
     * @var $formKeyValidator
     */
    protected $formKeyValidator;
    /**
     * @var $formBuilder
     */
    protected $formBuilder;
    
    /**
     * __construct
     *
     * @param     \Magento\Backend\Block\Widget\Context                 $context
     * @param     \Magento\Framework\Stdlib\DateTime\DateTime           $date
     * @param     \Magento\Framework\View\Result\PageFactory            $resultPageFactory
     * @param     \Magento\Framework\Data\Form\FormKey\Validator        $formKeyValidator
     * @param     \Webkul\FormBuilder\Model\FormFactory                 $formBuilder
     * @param     \Magento\Framework\Controller\Result\RedirectFactory  $resultRedirectFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Webkul\FormBuilder\Model\FormFactory $formBuilder,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->formKeyValidator = $formKeyValidator;
        $this->_date = $date;
        $this->formBuilder  = $formBuilder;
        $this->resultRedirectFactory  = $resultRedirectFactory;
    }

    /**
     * Function execute
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $continue = ($data['continue'] ?? 0);
        
        if ($this->formKeyValidator->validate($this->getRequest())) {
            $formModel;
            if ($data['entity_id']) {
                $formModel = $this->formBuilder->create()->load($data['entity_id']);
            } else {
                $formModel = $this->formBuilder->create();
                $formModel->setCreatedAt($this->_date->gmtDate());
            }
            try {
                $formModel->setName($this->validateData($data['title']));
                $formModel->setUrlKey($this->convert($this->validateData($data['title'])));
                $formModel->setSuccessUrl($this->validateData($data['success_url']));
                $formModel->setStatus(1);
                $formModel->setRecaptcha($this->validateData($data['recaptcha']));
                $formModel->setFormsFields(($data['forms_fields']));
                $formModel->setSubmitButton($this->validateData($data['submit_button'] ?? ""));
                $formModel->setStep1Label($this->validateData($data['step1_label'] ?? ""));
                $formModel->setLoginLabel($this->validateData($data['login_label'] ?? ""));
                $formModel->setCreateLabel($this->validateData($data['create_label'] ?? ""));
                $formModel->setSuccessMessage($this->validateData($data['success_message']));
                $formModel->setUpdatedAt($this->_date->gmtDate());
                $formModel->save();
                $this->messageManager->addSuccess(__('Form saved successfully.'));
                
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Something Went Wrong!!'));
            }
            if ($data['entity_id'] && $continue) {
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/edit/entity_id/'.$data['entity_id']);
                return $resultRedirect;
            } else {
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
            }
        } else {
            $this->messageManager->addError(__('Invalid Form Key'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;

        }
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
     * Create Url Key.
     *
     * @param string $string
     * @return string
     */
    protected function convert($string)
    {
        return (str_replace(' ', '-', strtolower($string)));
    }

    /**
     * Validate Form Data.
     *
     * @param string $data
     * @return string
     */
    private function validateData($data)
    {
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }
}
