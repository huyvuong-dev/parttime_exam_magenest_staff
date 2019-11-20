<?php

namespace Magenest\Staff\Model\ResourceModel\Staff;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
    protected function _construct() {
        $this->_init('Magenest\Staff\Model\Staff', 'Magenest\Staff\Model\ResourceModel\Staff');
    }
}