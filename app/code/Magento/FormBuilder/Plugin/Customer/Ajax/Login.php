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

namespace Webkul\FormBuilder\Plugin\Customer\Ajax;

class Login
{
    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $serializer;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Webkul\FormBuilder\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Integration\Model\Oauth\TokenFactory
     */
    protected $tokenModelFactory;

    public function __construct(
        \Magento\Framework\Serialize\Serializer\Json $serializer = null,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Integration\Model\Oauth\TokenFactory $tokenModelFactory,
        \Webkul\FormBuilder\Helper\Data $helper
    ) {
        $this->serializer = $serializer ?: \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Framework\Serialize\Serializer\Json::class);
        $this->customerSession = $customerSession;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->helper = $helper;
    }
    public function afterExecute(
        \Magento\Customer\Controller\Ajax\Login $subject,
        $result
    ) {
        /** @var \Magento\Framework\App\RequestInterface $request */
        $request = $subject->getRequest();

        $content = $request->getContent();
        if ($content) {
            $loginParams = $this->serializer->unserialize($content);
        }
        $username = $loginParams['username'] ?? null;
        $password = $loginParams['password'] ?? null;
        $rememberMe = $loginParams['persistent_remember_me'] ?? null;

        // customer have logged in successfully
        $customerLoggedInId = $this->customerSession->getCustomerId();
        if ($rememberMe && $customerLoggedInId) {
            try {
                $token = $this->tokenModelFactory->create()->createCustomerToken($customerLoggedInId)->getToken();
                $this->helper->setCustomerPersistentCookie($token);
            } catch (\Exception $e) {
                \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->alert('AFTER LOGIN ERROR : '.json_encode($e->getMessage()));
            }
        }
        return $result;
    }
}
