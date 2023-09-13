<?php
namespace Magento\AdminLiveChat\Controller\Adminhtml\Grid;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
class LoadAgents extends Action
{
    protected $jsonResultFactory;
    protected $customerData;

    public function __construct(Context $context, JsonFactory $jsonResultFactory)
    {
        parent::__construct($context);
        $this->jsonResultFactory = $jsonResultFactory;
    }

    public function execute()
    {
        $result = $this->jsonResultFactory->create();
        $param1 = $this->getRequest()->getParam('q');

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // require_once('path_to_magento/app/bootstrap.php');
        $bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
        $objectManager = $bootstrap->getObjectManager();
        $state = $objectManager->get('Magento\Framework\App\State');
        $state->setAreaCode('frontend');
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $query = "SELECT * FROM " . $resource->getTableName('customer_entity') ." WHERE group_id=1";
        $userData = $connection->fetchAll($query);
        return $result->setData($userData);
    }
}
