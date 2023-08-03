<?php

namespace Magento\CustomForm\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Bootstrap;
class SaveCustomer
{
    protected $customerRepository;
    protected $customerInterfaceFactory;
    protected $customerRegistry;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerInterfaceFactory $customerInterfaceFactory,
        CustomerRegistry $customerRegistry
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerInterfaceFactory = $customerInterfaceFactory;
        $this->customerRegistry = $customerRegistry;
    }

    public function saveCustomer(array $data): bool
    {
        // require 'app/bootstrap.php';
        $bootstrap = Bootstrap::create(BP, $_SERVER);
        $objectManager = $bootstrap->getObjectManager();
        try {
            // Create a new customer data object
            $customerDataObject = $this->customerInterfaceFactory->create();
            $customerDataObject->setGroupId(1);
            $customerDataObject->setFirstname($data['firstname']);
            $customerDataObject->setLastname($data['lastname']);
            $customerDataObject->setEmail($data['email']);
            $customerDataObject->setData('company',$data['company']);
            $customerDataObject->setData('phone',$data['phone']);
            // $customerDataObject->setPassword($data['password']);
            // Save the customer
            $hashedPassword = $objectManager->get('\Magento\Framework\Encryption\EncryptorInterface')->getHash($data['password'], true);
 
            $objectManager->get('\Magento\Customer\Api\CustomerRepositoryInterface')->save($customerDataObject, $hashedPassword);
            // $customer = $this->customerRepository->save($customerDataObject);

            // Set the password for the customer
            // $customerId = $customer->getId();
            // $customerModel = $this->customerRegistry->retrieve($customerId);
            // $customerModel->setPassword($data['password']);
            // $this->customerRepository->save($customerModel);

            return true;
        } catch (LocalizedException $e) {
            // Handle localized exception
        }

        return false;
    }
}


