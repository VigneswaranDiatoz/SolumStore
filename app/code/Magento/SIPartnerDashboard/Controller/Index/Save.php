<?php

namespace Magento\SIPartnerDashboard\Controller\Index;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_contactFactory;

    public function __construct(
    \Magento\Framework\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $pageFactory,
    \Magento\SIPartnerDashboard\Model\ContactFactory $contactFactory
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
            if($input['editId']){
                $postData->load($input['editId']);
                $postData->addData($input);
                $postData->setId($input['editId']);
                $postData->save();
            }else{
                $postData->setData($input)->save();
            }
            return $this->_redirect('mymodule/index/index');
        }
    }
}