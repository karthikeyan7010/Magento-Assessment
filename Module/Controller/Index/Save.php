<?php

/**
 * Preorder Module Form Render
 */

namespace Preorder\Module\Controller\Index;

use Preorder\Module\Model\ModuleFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Save extends \Magento\Framework\App\Action\Action
{
    
    protected $_dataExample;

    protected $_messageManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Preorder\Module\Model\ModuleFactory   $dataExample,
        \Magento\Framework\Controller\ResultFactory $result,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->_dataExample = $dataExample;
        $this->_messageManager = $messageManager;
    }

    /**
     * Save Data & Redirect
     *
     * @return $resultRedirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $model = $this->_dataExample->create();
        $model->setData($data);
        $saveData = $model->save();
        if ($saveData) {
            $this->_messageManager->addSuccess('Your Preorder is Placed.');
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('/');
        return $resultRedirect;
    }
}
