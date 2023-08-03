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
use Magento\Backend\App\Action\Context;

use Webkul\FormBuilder\Model\ResourceModel\Response\CollectionFactory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context           $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * Execute action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     *
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $id =  $this->getRequest()->getParam('entity_id');
        
        $collection   =  $this->collectionFactory->create();
        $collection   =  $collection->addFieldToFilter('entity_id', $id);

        if (($collection->getSize()) > 0) {
            $countRecord = $collection->getSize();
            $formId;
            foreach ($collection as $item) {
                $formId = $item->getFormId();
                $item->delete();
            }
            $this->messageManager->addSuccess(
                __(
                    'A total of %1 record(s) have been deleted.',
                    $countRecord
                )
            );
    
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('*/*/index/', ['form_id'=>$formId]);
        } else {
             /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
             $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
             return $resultRedirect->setPath('*/*/index/');
        }
    }
    
    /**
     * Function _isAllowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_FormBuilder::response');
    }
}
