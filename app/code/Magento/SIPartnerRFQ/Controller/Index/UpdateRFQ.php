<?php

namespace Magento\SIPartnerRFQ\Controller\Index;

class UpdateRFQ extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_contactFactory;

    public function __construct(
    \Magento\Framework\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $pageFactory,
    \Magento\CustomerRFQ\Model\GridFactory $contactFactory
    ){
        $this->_pageFactory = $pageFactory;
        $this->_contactFactory = $contactFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        if ($this->getRequest()->isPost()) {
            $input = $this->getRequest()->getPostValue();
            $postData = $this->_contactFactory->create();
                $postData->load($input['id']);
                $postData->addData($input);
                $postData->setId($input['id']);
                $postData->save();
            return $this->_redirect('sipartnerrfq/index');
        }
    }
}