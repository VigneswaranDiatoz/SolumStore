<?php
namespace Magento\AdminLiveChat\Controller\Adminhtml\Grid;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
class LoadChat extends Action
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
        $threadId = $this->getRequest()->getParam('threadId');
        $userids = $this->getRequest()->getParam('userId');

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $select = $connection->select()->from("messages")->where("convo_id = ?", $threadId);

        $resultRows = $connection->fetchAll($select);
        $userIds = explode(",", $userids);

        $bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
        $objectManager = $bootstrap->getObjectManager();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $userData=[];
         foreach ($userIds as $userId) {
            $query = "SELECT * FROM " . $resource->getTableName('customer_entity') ." WHERE entity_id=".$userId;
            $userData[] = $connection->fetchRow($query);
         }
        return $result->setData(array($resultRows,$userData));
    }
}
