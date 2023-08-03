<?php

namespace Magento\CustomForm\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Bootstrap;
class SaveSellerPartner
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

    public function saveSellerPartner(array $data): bool
    {
        // require 'app/bootstrap.php';
        $bootstrap = Bootstrap::create(BP, $_SERVER);
        $objectManager = $bootstrap->getObjectManager();
        try {
            // Create a new customer data object
            // var_dump($data);
            $customerDataObject = $this->customerInterfaceFactory->create();
            $customerDataObject->setGroupId(4);
            $customerDataObject->setFirstname($data['company']);
            $customerDataObject->setEmail($data['email']);
            $customerDataObject->setData('company',$data['company']);
            $customerDataObject->setLastname($data['company']);
            $customerDataObject->setData('is_active',false);
            // $customerDataObject->setData('phone',$data['phone']);
            // $customerDataObject->setPassword($data['password']);
            // Save the customer
            $hashedPassword = $objectManager->get('\Magento\Framework\Encryption\EncryptorInterface')->getHash($data['password'], true);
            
            $save=$objectManager->get('\Magento\Customer\Api\CustomerRepositoryInterface')->save($customerDataObject, $hashedPassword);
            $customer = $this->customerRepository->getById($save->getId());
                // var_dump($customer);die();
                // Update customer account details
                // $customer->setFirstname($data['businessname']);
                // $customer->setLastname($data['company']);
                // $customer->setEmail($data['email']);
                // $customer->setData('business_name','ytr');
                // $customer->setCustomAttribute('business_name',$data['company']);
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
                $tableName = $resource->getTableName('customer_entity');
                $data = [
                    'business_name' => $data['company'],
                    'is_active' => 0,
                ];

                $condition = ['entity_id = ?' => $save->getId()];
                $connection->update($tableName, $data, $condition);
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


