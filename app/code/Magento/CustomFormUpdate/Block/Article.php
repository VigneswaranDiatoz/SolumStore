<?php
namespace Magento\CustomFormUpdate\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Customer\Model\Session;

class Article extends Template
{
    protected $_sessionManager;
    /**
     * Constructor
     *
     * @param Context $context
     * @param array $data
    */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = [],Session $session
    ){
        $this->_sessionManager = $session;
        parent::__construct($context, $data);
     }

    /**
     * @return Post[]
    */
    public function getArticles()
    {
        return $this->_sessionManager->isLoggedIn();
    }
}
?>