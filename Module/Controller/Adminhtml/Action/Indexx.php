<?php

/**
 * Preorder Module Grid Render
 */

namespace Preorder\Module\Controller\Adminhtml\Action;

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
     * Render Grid
     *
     * @return $resultPage
     */
    public function execute()
    {
        $resultPage =  $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Preorder Details'));
        return $resultPage;
    }

    /**
     * Check Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Preorder_Module::preorder');
    }
}
