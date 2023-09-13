<?php

namespace Magento\AdminLiveChat\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ConversationList extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('thread', 'id');
    }

    public function runCustomQuery($query)
    {
        $connection = $this->getConnection();
        return $connection->fetchAll($query);
    }
}
