<?php

/**
 * Define main table
 */

namespace Preorder\Module\Model\ResourceModel;

class Module extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('preorder_module_post', 'preorder_id');
    }
}
