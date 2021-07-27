<?php

/**
 * Preorder Module Get Current Product Items
 */

namespace Preorder\Module\Block;

class GetProducts extends \Magento\Framework\View\Element\Template
{
    public $registry;
    
    protected $_objectManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }
}
