<?php

namespace Magento\CustomFormUpdate\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Bootstrap;
use Magento\Customer\Model\Session;
class SaveSellerPartner
{
    protected $session;
    protected $customerRepository;
    protected $customerInterfaceFactory;
    protected $customerRegistry;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerInterfaceFactory $customerInterfaceFactory,
        CustomerRegistry $customerRegistry,
        Session $session
    ) {
        $this->session = $session;
        $this->customerRepository = $customerRepository;
        $this->customerInterfaceFactory = $customerInterfaceFactory;
        $this->customerRegistry = $customerRegistry;
    }

    public function saveSellerPartner(array $data): bool
    {
        // require 'app/bootstrap.php';
        // var_dump($this->session->isLoggedIn());
        // var_dump($this->session->getCustomerId());
        // die();
        if ($this->session->isLoggedIn()) {
            $customerId = $this->session->getCustomerId();
            // var_dump($customerId);
            // die();            // Get customer data from the form
            // $updatedData = $this->getRequest()->getPost();

            try {
                // Load the customer object
                $customer = $this->customerRepository->getById($customerId);
                // var_dump($customer);die();
                // Update customer account details
                // $customer->setFirstname($data['businessname']);
                // $customer->setLastname($data['company']);
                // $customer->setEmail($data['email']);
                // $customer->setData('business_name','ytr');
                $customer->setCustomAttribute('business_name','sasa');
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
                $tableName = $resource->getTableName('customer_entity');
                $data = [
                    'business_name' => $data['businessName'],
                    'phone_number' => $data['phoneNumber'],
                    'contact_info' => $data['contactInfo'],
                    'address' => $data['address'],
                    'email' => $data['email'],
                    'credit_card_info' => $data['creditCardInfo'],
                    'tax_id' => $data['taxId'],
                    'state_tax_id' => $data['stateTaxId'],
                    'esl' => $data['esl'],
                    'solum_partner' => $data['solumPartner'],
                    'sales_size' => $data['salsSize'],
                    'credit_ratings' => $data['creditRatings'],
                    'business_area' => $data['businessArea'],
                    'pos' => $data['pos'],
                    'docs' => $data['docs'],
                ];

                $condition = ['entity_id = ?' => $customerId];
                $connection->update($tableName, $data, $condition);
                // $tableName = $resource->getTableName('customer_entity');
                // Set other fields as needed
                // $sql = "Update " . $tableName . " Set business_name = '".$data['businessName']."',phone_number = '".$data['phoneNumber']."' where entity_id =".$customerId;
                // $connection->query($sql);
                return true;
            } catch (\Exception $e) {
                // Handle exceptions and display error message
                // $this->messageManager->addErrorMessage(__('An error occurred while updating customer account details.'));
                // $this->_redirect('customer/account');
                return false;
            }
        } else {
            return false;
        }

        // If customer is not logged in, redirect to login page
        // $this->_redirect('customer/account/login');
    }
}


