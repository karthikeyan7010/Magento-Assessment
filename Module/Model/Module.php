<?php

/**
 * Define resource model
 */

namespace Preorder\Module\Model;

use Magento\Framework\Model\AbstractModel;

class Module extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Preorder\Module\Model\ResourceModel\Module::class);
    }
}
