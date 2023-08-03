<?php
namespace Magento\SIPartnerGrid\Controller\Adminhtml\Grid;

use Magento\Framework\Controller\ResultFactory;

class ChangeStatus extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Magento\SIPartnerGrid\Model\GridFactory
     */
    private $gridFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Magento\SIPartnerGrid\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\SIPartnerGrid\Model\GridFactory $gridFactory
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
        $tableName = $resource->getTableName('customer_entity');
        $data = [
            'is_active' => $userStatus,
        ];

        $condition = ['entity_id = ?' => $rowId];
        $connection->update($tableName, $data, $condition);
        // $this->messageManager->addError(__('row data no longer exist.'));
        $this->_redirect('sipartnergrid/grid/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_SIPartnerGrid::add_row');
    }
}