<?php

/**
 * Preorder Module Bulk Mail
 */

namespace Preorder\Module\Controller\Adminhtml\Action;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Preorder\Module\Model\ModuleFactory;
use Preorder\Module\Model\ResourceModel\Module\CollectionFactory;
use Preorder\Module\Helper\Emaill;

class Bulk extends Action
{
 
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var Helper
     */
    protected $_helper;

    /**
     *
     * @var PreorderFactory
     */
    protected $moduleFactory;

    /**
     * @var string
     */
    protected $redirectUrl = '*/*/index';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;
 
    /**
     * View constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct( $context, $result, Emaill $helper,$filter, $CollectionFactory,$ModuleFactory)
    {
        $this->_resultPageFactory = $result;
        $this->_helper = $helper;
        $this->moduleFactory =$ModuleFactory;
        $this->filter = $filter;
        $this->collectionFactory =  $CollectionFactory;
        parent::__construct($context);
    }

    /**
     * Return redirect url
     *
     * @return null|string
     */
    protected function getRedirectUrl()
    {
        return $this->filter->getComponentRefererUrl() ?: 'preorder_grid/*/index';
    }
 
    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $data = $this->getRequest()->getParams();

        if ($data['status']==1) {
            $send_message_attribute = "approved";
            $send_message_attribute_c = "confirm";
            $status = 1;
        } else {
            $send_message_attribute = "cancelled";
            $send_message_attribute_c = "inform";
            $status = 2;
        }

        try {
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');

                $logger = new \Zend\Log\Logger();

                $logger->addWriter($writer);

                $logger->info('came2');

            $collection = $this->collectionFactory->create();
            //$logger->info(print_r($collection,1));

            $customersUpdated = 0;
            foreach ($collection->getAllIds() as $id) {
                
                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');

                $logger = new \Zend\Log\Logger();

                $logger->addWriter($writer);

                $logger->info('came');

                $model = $this->moduleFactory->create();
                $model->load($id);
                $firstname = $model->getData('firstname');
                $email = $model->getData('email');
                $sku = $model->getData('sku');
                $product = $model->getData('product');
                $model->setData('status', $status);
                
                $data = ['send_message_attribute_c'=>$send_message_attribute_c
                         ,'send_message_attribute'=>$send_message_attribute ,
                        'sku'=>$sku ,
                        'product'=>$product ,
                        'status'=>$status];
                $block = $resultPage->getLayout()
                    ->createBlock(\Preorder\Module\Block\Emailblock::class)
                    ->setTemplate('Preorder_Module::email_template.phtml')
                    ->setData('data', $data)
                    ->toHtml();

                $to = $email;
                $type = "";
                $sendMail = $this->_helper->sendMail($to, $to, $block, $type);
                $this->messageManager->addSuccess(__('Preorder status mail sent successfully'));
                $model->save();
                $customersUpdated++;
            }
            if ($customersUpdated) {
                $this->messageManager
                ->addSuccessMessage(__('A total of %1 record(s) were updated.', $customersUpdated));
            }
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath($this->getRedirectUrl());
            return $resultRedirect;
        } catch (\Exception $e) {
            
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');

                $logger = new \Zend\Log\Logger();

                $logger->addWriter($writer);

                $logger->info('came1');

                $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($this->redirectUrl);
        }
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
