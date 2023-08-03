<?php

namespace Magento\SIDashboard\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\Data\ImageContentInterfaceFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Customer\Model\Session as CustomerSession;
class SaveProduct extends Action
{
    private $customerSession;
    /**
     * @var ProductInterfaceFactory
     */
    protected $productInterfaceFactory;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ImageContentInterfaceFactory
     */
    protected $imageContentInterfaceFactory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var AdapterFactory
     */
    protected $imageAdapterFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;
    public function __construct(
        Context $context,
        ProductInterfaceFactory $productInterfaceFactory,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        ImageContentInterfaceFactory $imageContentInterfaceFactory,
        Filesystem $filesystem,
        AdapterFactory $imageAdapterFactory,
        ManagerInterface $messageManager,
        CustomerSession $customerSession
    ) {
        parent::__construct($context);
        $this->productInterfaceFactory = $productInterfaceFactory;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->imageContentInterfaceFactory = $imageContentInterfaceFactory;
        $this->filesystem = $filesystem;
        $this->imageAdapterFactory = $imageAdapterFactory;
        $this->messageManager = $messageManager;
        $this->customerSession = $customerSession;
    }

    public function execute()
    {
        // Create a new product
        $postData = $this->getRequest()->getPostValue();
        if (!$postData) {
            return $this->_redirect('sidashboard/index/insert');
        }
        $product = $this->productInterfaceFactory->create();
        $product->setSku($postData["product_sku"]);
        $product->setName($postData["product_name"]);
        $product->setPrice($postData["product_price"]);
        $product->setAttributeSetId(4); // Use the appropriate attribute set ID for your product type
        $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $product->setTypeId('simple'); // Use the appropriate product type (simple, configurable, grouped, etc.)
        $product->setWebsiteIds([$this->storeManager->getWebsite()->getId()]); // Set the website ID(s) to associate the product with

        // Set other attributes as needed
        $product->setDescription($postData["product_name"]);
        $product->setShortDescription($postData["product_description"]);
            $product->setStockData([
                'is_in_stock' =>true,
                'qty' => $postData["stock_qty"]
            ]);
        // Add an image to the product
        // $imagePath = '/path/to/your/image.jpg'; // Replace with the actual path to your image
        // if (file_exists($imagePath)) {
        //     $product->setMediaGalleryEntries([
        //         [
        //             'media_type' => \Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface::MEDIA_TYPE_IMAGE,
        //             'label' => 'Sample Image',
        //             'file' => $imagePath,
        //             'types' => ['image', 'small_image', 'thumbnail'],
        //             'content' => $   this->imageContentInterfaceFactory->create(['base64EncodedData' => base64_encode(file_get_contents($imagePath))]),
        //         ],
        //     ]);
        // }

        // Save the product
        try {
            $product = $this->productRepository->save($product);
            // var_dump($product);die();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
                $tableName = $resource->getTableName('catalog_product_entity');
                $data = [
                    'created_by' => $this->customerSession->getCustomerId()
                ];

                $condition = ['entity_id = ?' => $product->getId()];
                
                $connection->update($tableName, $data, $condition);
            $this->messageManager->addSuccessMessage(__('Product with SKU %1 has been created successfully.', $product->getSku()));
            // var_dump($product->getSku());die();
        } catch (\Exception $e) {
            // var_dump($e->getMessage());die();
            // var_dump($e);die();
            $this->messageManager->addErrorMessage(__('Error: %1', $e->getMessage()));
        }
        // var_dump("end");die();
        // Redirect to a custom success page or any other page as needed
        return $this->_redirect('sidashboard/index/products');
    }
}
