<?php

namespace Magento\ProductList\Block;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Products extends Template
{
    protected $productRepository;
    protected $searchCriteriaBuilder;
    protected $_contactFactory;

    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,ProductRepositoryInterface $productRepository,
    SearchCriteriaBuilder $searchCriteriaBuilder,
    array $data = []) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    // public function getProducts()
    // {
    //     // $contact = $this->_contactFactory->create();
    //     // $collection = $contact->getCollection();
    //     $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
    //     $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
    //     $connection = $resource->getConnection();
    //     $select = $connection->select()
    //         ->from('customer_entity')
    //         ->where('group_id = 4')
    //         ->where('is_active!=3');
    //     $result = $connection->fetchAll($select);
    //     return $result;
    // }
    public function getProducts()
    {
        // $this->searchCriteriaBuilder->addFilter('new', '1');
        // $this->searchCriteriaBuilder->addFilter('status', '1');
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $products = $this->productRepository->getList($searchCriteria)->getItems();
        
        return $products;
    }
    public function getCustomerId(){
        $objectManager = ObjectManager::getInstance();
        $sessionManager = $objectManager->get(\Magento\Framework\Session\SessionManagerInterface::class);
        $sessionId = $sessionManager->getSessionId();
        return $sessionId;
    }
}