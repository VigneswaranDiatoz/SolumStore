<?php

namespace Magento\SIDashboard\Block;

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
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->context = $context;
    }

    /**
     * Get product data by ID
     *
     * @param int $productId
     * @return \Magento\Catalog\Api\Data\ProductInterface|null
     */
    public function getProductById()
    {
        $productId = $this->context->getRequest()->getParam('id');
        var_dump($productId);die();
        try {
            return $this->productRepository->getById($productId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            // Handle the exception if the product doesn't exist
            return null;
        }
    }
}
