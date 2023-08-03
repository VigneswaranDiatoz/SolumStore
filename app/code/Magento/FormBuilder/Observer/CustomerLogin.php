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

namespace Webkul\FormBuilder\Observer;

use Magento\Customer\Model\Session;
use Magento\Framework\UrlFactory;
use \Webkul\FormBuilder\Helper\Data as Helper;

class CustomerLogin implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var Helper
     */
    private $helper;
   
    public function __construct(
        Session $customerSession,
        Helper $helper
    ) {
        $this->customerSession = $customerSession;
        $this->helper = $helper;
    }

    /**
     * Customer Logout Observer Execute Method
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $controller = $observer->getEvent()->getData('request')->getFullActionName();
        if (!$this->customerSession->isLoggedIn() && $controller != 'customer_account_logoutSuccess') {
            $returnMsg = $this->helper->verifyCustomerPersistentCookieToken();
            \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')
            ->alert('AFTER LOGIN OBSERVER RETURN : '.json_encode($returnMsg));
        }
    }
}
