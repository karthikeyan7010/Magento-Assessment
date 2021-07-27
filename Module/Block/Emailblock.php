<?php

/**
 * Preorder Module Email Block
 */

namespace Preorder\Module\Block;
 
use Magento\Framework\View\Element\Template;
$this->registry = $registry;
parent::__construct($context, $data);
}

class Emailblock extends Template
{
    public function getEmailtemplates($templateId)
    {
        return $templateId;
    }
}
