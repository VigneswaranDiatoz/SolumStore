<?php

namespace Magento\CustomForm\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\CustomForm\Model\SaveSellerPartner;

class SavePartner extends \Magento\Framework\App\Action\Action
{
    protected $resultFactory;
    protected $saveSellerPartner;

    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        SaveSellerPartner $saveSellerPartner
    ) {
        $this->resultFactory = $resultFactory;
        $this->saveSellerPartner = $saveSellerPartner;
        parent::__construct($context);
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();

        if (!empty($postData)) {
                if ($this->saveSellerPartner->saveSellerPartner($postData)) {
                    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    $resultRedirect->setUrl('customer/account/login');
                    return $resultRedirect;
                } else {
                    // Handle failure
                }
        }
    }
}
