<?php

/**
 * Preorder Module Form Render
 */

namespace Preorder\Module\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * Render Form
     *
     * @return $resultPage
     */
    public function execute()
    {
        $resultPage =  $this->_pageFactory->create();
        return $resultPage;
    }
}
