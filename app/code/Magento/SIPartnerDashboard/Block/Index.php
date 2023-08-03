<?php

namespace Magento\SIPartnerDashboard\Block;

use Magento\Framework\View\Element\Template;

class Index extends Template
{
    protected $_contactFactory;

    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context) {
        parent::__construct($context);
    }

    public function getData()
    {
        // $contact = $this->_contactFactory->create();
        // $collection = $contact->getCollection();
        return "collection";
    }
}