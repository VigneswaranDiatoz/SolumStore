<?php
namespace Magento\AdminLiveChat\Controller\Adminhtml\Grid;

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
        $threadId = $this->getRequest()->getParam('thread');

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('messages');
        $data = [
            'user_id' => $userid,
            'convo_id'=>$threadId,
            'message'=>$message
        ];

        // Insert query
        $connection->insert($tableName, $data);
        $query = "SELECT * FROM " . $resource->getTableName('thread') ." WHERE id=".$threadId;
        $threadData = $connection->fetchRow($query);
        $userIds = explode(",", $threadData["user_ids"]);
        if(array_search('0', $userIds)){
            $users=[];
            foreach ($userIds as $userId) {
                if($userId!=0){
                    array_push($users,$userId);
                }
            }
            array_push($users,$userid);
            
            $data = [
                'user_ids' => implode(",",$users)
            ];
            $tableName = $resource->getTableName('thread');
            $where = ['id = ?' => $threadId];
            $connection->update($tableName, $data, $where);
        }

        return $result->setData(array($connection->lastInsertId()));
    }
}
