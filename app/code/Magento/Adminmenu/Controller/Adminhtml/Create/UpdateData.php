<?php
namespace Magento\Adminmenu\Controller\Adminhtml\Create;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class UpdateData implements ActionInterface
{
    protected $resultJsonFactory;
    protected $request;

    public function __construct(
        RequestInterface $request,
        JsonFactory $resultJsonFactory
    ) {
        $this->request = $request;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
    
        $userStatus=0;
        if($this->request->getParam('action') == 'accept'){
            $userStatus=1;
        } else if($this->request->getParam('action') == 'decline'){
            $userStatus=3;
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('customer_entity');
        $data = [
            'is_active' => $userStatus,
        ];

        $condition = ['entity_id = ?' => $this->request->getParam('id')];
        $connection->update($tableName, $data, $condition);
        $result = $this->resultJsonFactory->create();
        $result->setData(['message' => 'AJAX response']);
        return $result;
        // return $connection->update($tableName, $data, $condition);
    }
}
