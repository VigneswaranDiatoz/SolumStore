<?php

namespace Magento\SIPartnerRFQ\Block;
use Magento\SIPartnerRFQ\Model\ResourceModel\Grid\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\Template;
// use Magento\Backend\App\Action\Context;

class Edit extends Template
{
    private $productRepository;
    // protected $context;
    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        // Context $context,
        array $data = [],CollectionFactory $contactFactory
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->context = $context;
        $this->_contactFactory = $contactFactory;
    }

    /**
     * Get product data by ID
     *
     * @param int $productId
     * @return \Magento\Catalog\Api\Data\ProductInterface|null
     */
    public function getRFQById()
    {
        $rfqId = $this->context->getRequest()->getParam('id');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $select = $connection->select()
            ->from('product_rfq')
            ->where("entity_id = $rfqId");
            // ->where('is_active!=3');
        $result = $connection->fetchAll($select);
        return $result;
    }
}
