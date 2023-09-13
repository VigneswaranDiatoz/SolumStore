<?php
namespace Magento\CustomerLiveChat\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
class SaveChat extends Action
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
        $message = $this->getRequest()->getParam('message');
        $userid = $this->getRequest()->getParam('userId');

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $select = $connection->select()->from("messages")->where("user_id = ?", $userid);

        $resultRows = $connection->fetchAll($select);
        $threadId=0;
        if(count($resultRows) ==0){
            $tableName = $resource->getTableName('thread');
            $data = [
                'user_ids' => "$userid,0"
            ];

            // Insert query
            $connection->insert($tableName, $data);
            $threadId = $connection->lastInsertId();
        }else {
           $threadId= $resultRows[0]["convo_id"];
        }
        $tableName = $resource->getTableName('messages');
            $data = [
                'user_id' => $userid,
                'convo_id'=>$threadId,
                'message'=>$message
            ];

            // Insert query
            $connection->insert($tableName, $data);
        return $result->setData(array($connection->lastInsertId()));
    }
}
