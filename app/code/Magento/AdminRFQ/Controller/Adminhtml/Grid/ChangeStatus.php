<?php
namespace Magento\AdminRFQ\Controller\Adminhtml\Grid;

use Magento\Framework\Controller\ResultFactory;

class ChangeStatus extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Magento\AdminRFQ\Model\GridFactory
     */
    private $gridFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Magento\AdminRFQ\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\AdminRFQ\Model\GridFactory $gridFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->gridFactory = $gridFactory;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId =$this->getRequest()->getParam('id');
        $action=$this->getRequest()->getParam('action');
        $userStatus=0;
        if($action == 'accept'){
            $userStatus=1;
        } else if($action == 'decline'){
            $userStatus=3;
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('product_rfq');
        $data = [
            'is_active' => $userStatus,
        ];

        $condition = ['entity_id = ?' => $rowId];
        $connection->update($tableName, $data, $condition);
        // $this->messageManager->addError(__('row data no longer exist.'));
        $this->_redirect('adminrfq/grid/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_AdminRFQ::add_row');
    }
}