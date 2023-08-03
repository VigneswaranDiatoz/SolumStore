<?php

namespace Magento\CustomForm\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\CustomForm\Model\SaveCustomer;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $resultFactory;
    protected $saveCustomer;

    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        SaveCustomer $saveCustomer
    ) {
        $this->resultFactory = $resultFactory;
        $this->saveCustomer = $saveCustomer;
        parent::__construct($context);
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();

        if (!empty($postData)) {
                if ($this->saveCustomer->saveCustomer($postData)) {
                    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    $resultRedirect->setUrl('customer/account/login');
                    return $resultRedirect;
                } else {
                    // Handle failure
                }
        }
    }
}
