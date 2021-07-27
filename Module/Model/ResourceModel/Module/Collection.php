<?php

/**
 * Define resource model & model
 */

namespace Preorder\Module\Model\ResourceModel\Module;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    
    public function _construct()
    {
        $this->_init(\Preorder\Module\Model\Module::class, \Preorder\Module\Model\ResourceModel\Module::class);
    }
}
