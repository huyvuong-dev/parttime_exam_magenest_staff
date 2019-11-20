<?php

namespace Magenest\Staff\Model;

use Magento\Framework\Model\AbstractModel;

class Staff extends AbstractModel {
    protected function _construct() {
        /* full resource classname */
        $this->_init('Magenest\Staff\Model\ResourceModel\Staff');
    }
}
