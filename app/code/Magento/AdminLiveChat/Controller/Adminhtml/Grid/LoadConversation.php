<?php
namespace Magento\AdminLiveChat\Controller\Adminhtml\Grid;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
class LoadConversation extends Action
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
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $select = $connection->select()->from("thread");

        $resultRows = $connection->fetchAll($select);
        $allData = [];
        // require_once('path_to_magento/app/bootstrap.php');
        $bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
        $objectManager = $bootstrap->getObjectManager();
        $state = $objectManager->get('Magento\Framework\App\State');
        $state->setAreaCode('frontend');
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $unreadData=[];
        foreach ($resultRows as $row) {
            $userIds = explode(",", $row["user_ids"]);
            $userData = [];
            
            $query = "SELECT * FROM " . $resource->getTableName('customer_entity') ." WHERE entity_id=".$userIds[0];
            $userData = $connection->fetchRow($query);

            $query = "SELECT * FROM " . $resource->getTableName('messages') ." WHERE status=0 AND user_id=".$userIds[0];
            
            $unreadData = $connection->fetchAll($query);
            if(!$unreadData){
                $unreadData=[];
            }
        // var_dump($unreadData);die();
            // foreach ($userIds as $userId) {
            //     try {
            //         $customer = $this->CustomerFactory->getById($userId);
            //         $userData[] = [
            //             'id' => $userId,
            //             'name' => $customer->getFirstname() . ' ' . $customer->getLastname()
            //         ];
            //     } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            //         // Handle exception if customer doesn't exist
            //     }
            // }
            $allData[] = [
                'id' => $row["id"],
                'user_name' =>$userData["firstname"]." ".$userData["lastname"],
                'user_ids'=>$row["user_ids"],
                'user_id'=>$userIds[0],
                'unread'=>count($unreadData)
            ];
        }

        // $data = [
        //     'message' => 'Your AJAX call was successful!',
        //     'res' => $allData
        //     // other data you want to send back
        // ];
        // var_dump($data);die();
        return $result->setData($allData);
    }
}
