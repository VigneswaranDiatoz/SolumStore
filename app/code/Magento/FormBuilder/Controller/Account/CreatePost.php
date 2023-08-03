<?php
/**
 *
 * @category  Webkul
 * @package   Webkul_MpOrderEdit
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\FormBuilder\Controller\Account;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\MessageInterface;
use Magento\Framework\App\ObjectManager;

class CreatePost extends \Magento\Customer\Controller\Account\CreatePost
{

    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    /**
     * @var \Magento\Framework\Stdlib\Cookie\PhpCookieManager
     */
    private $cookieMetadataManager;
 
    public function execute()
    {
        $resultData = [
            "errors" => true,
            "msg" => __("Something went wrong.")
        ];
        if ($this->session->isLoggedIn() || !$this->registration->isAllowed()) {
            return $this->getResponse()->representJson(
                json_encode($resultData)
            );
        }

        if (!$this->getRequest()->isPost()) {
            return $this->getResponse()->representJson(
                json_encode($resultData)
            );
        }
        $this->session->regenerateId();
        try {
            $address = $this->extractAddress();
            $addresses = $address === null ? [] : [$address];
            $customer = $this->customerExtractor->extract('customer_account_create', $this->_request);
            $customer->setAddresses($addresses);
            $password = $this->getRequest()->getParam('password');
            $confirmation = $this->getRequest()->getParam('password_confirmation');
            $redirectUrl = $this->session->getBeforeAuthUrl();
            $this->checkPasswordConfirmation($password, $confirmation);

            $extensionAttributes = $customer->getExtensionAttributes();
            $extensionAttributes->setIsSubscribed($this->getRequest()->getParam('is_subscribed', false));
            $customer->setExtensionAttributes($extensionAttributes);

            $customer = $this->accountManagement
                ->createAccount($customer, $password, $redirectUrl);

            $this->_eventManager->dispatch(
                'customer_register_success',
                ['account_controller' => $this, 'customer' => $customer]
            );
            $confirmationStatus = $this->accountManagement->getConfirmationStatus($customer->getId());
            if ($confirmationStatus === AccountManagementInterface::ACCOUNT_CONFIRMATION_REQUIRED) {
                $resultData = [
                    "errors" => false,
                    "alert" => true,
                    "title" => __('Confirm Email Address'),
                    "reload" => false,
                    "msg" =>  __('You must confirm your account. Please check your email for the confirmation link or <a href="%1">click here</a> to resend a new link.', $this->customerUrl->getEmailConfirmationUrl($customer->getEmail()))
                ];
                return $this->getResponse()->representJson(
                    json_encode($resultData)
                );
            } else {
                $this->session->setCustomerDataAsLoggedIn($customer);
                $resultData = [
                    "errors" => false,
                    "alert" => true,
                    "title" => __('Registered Successfully'),
                    "reload" => true,
                    "msg" => $this->getMessageManagerSuccessMessage()->getText()
                ];
            }
            if ($this->getCookieManager()->getCookie('mage-cache-sessid')) {
                $metadata = $this->getCookieMetadataFactory()->createCookieMetadata();
                $metadata->setPath('/');
                $this->getCookieManager()->deleteCookie('mage-cache-sessid', $metadata);
            }
        } catch (StateException $e) {
            $resultData = [
                "errors" => false,
                "alert" => true,
                "title" => __('Already Have Account with Us'),
                "reload" => false,
                "msg" =>  __('There is already an account with this email address. If you are sure that it is your email address, <a href="%1">click here</a> to get your password and access your account.', $this->urlModel->getUrl('customer/account/forgotpassword'))
            ];
        } catch (InputException $e) {
            $resultData = [
                "errors" => true,
                "msg" =>  $e->getMessage()
            ];
            foreach ($e->getErrors() as $error) {
                $resultData["msg"] .= ", ".$error->getMessage();
            }
        } catch (LocalizedException $e) {
            $resultData = [
                "errors" => true,
                "msg" =>  $e->getMessage()
            ];
        } catch (\Exception $e) {
            $resultData = [
                "errors" => true,
                "msg" =>  __('We can\'t save the customer.')
            ];
        }
        return $this->getResponse()->representJson(
            json_encode($resultData)
        );
    }

    /**
     * Retrieve success message manager message
     *
     * @return MessageInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getMessageManagerSuccessMessage(): MessageInterface
    {
        if ($this->addressHelper->isVatValidationEnabled()) {
            if ($this->addressHelper->getTaxCalculationAddressType() == Address::TYPE_SHIPPING) {
                $identifier = 'customerVatShippingAddressSuccessMessage';
            } else {
                $identifier = 'customerVatBillingAddressSuccessMessage';
            }

            $message = $this->messageManager
                ->createMessage(MessageInterface::TYPE_SUCCESS, $identifier)
                ->setData(
                    [
                        'url' => $this->urlModel->getUrl('customer/address/edit'),
                    ]
                );
        } else {
            $message = $this->messageManager
                ->createMessage(MessageInterface::TYPE_SUCCESS)
                ->setText(
                    __('Thank you for registering with %1.', $this->storeManager->getStore()->getFrontendName())
                );
        }

        return $message;
    }

    /**
     * Retrieve cookie manager
     *
     * @deprecated 100.1.0
     * @return \Magento\Framework\Stdlib\Cookie\PhpCookieManager
     */
    private function getCookieManager()
    {
        if (!$this->cookieMetadataManager) {
            $this->cookieMetadataManager = ObjectManager::getInstance()->get(
                \Magento\Framework\Stdlib\Cookie\PhpCookieManager::class
            );
        }
        return $this->cookieMetadataManager;
    }

    /**
     * Retrieve cookie metadata factory
     *
     * @deprecated 100.1.0
     * @return \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */
    private function getCookieMetadataFactory()
    {
        if (!$this->cookieMetadataFactory) {
            $this->cookieMetadataFactory = ObjectManager::getInstance()->get(
                \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory::class
            );
        }
        return $this->cookieMetadataFactory;
    }
}
