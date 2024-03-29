<?php
namespace Magenest\Staff\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Staff extends AbstractDb {
    protected function _construct() {
        /* tablename, primarykey*/
        $this->_init('magenest_staff', 'id');
    }
}
