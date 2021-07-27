<?php

/**
 * Preorder Module Grid Render
 */

namespace Preorder\Module\Controller\Adminhtml\Action;

class Sendmail extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $resultFactory;

    protected $_helper;

    const QUOTE_TABLE = 'preorder_module_post';

    private $resource;

    private $_deploymentConfig;

    public function __construct(
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Preorder\Module\Helper\Emaill $helper,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig
    ) {
        $this->_pageFactory = $pageFactory;
        $this->resultFactory = $resultFactory;
        $this->resource = $resource;
        $this->_helper = $helper;
        $this->_deploymentConfig = $deploymentConfig;
        return parent::__construct($context);
    }

    /**
     * Render Grid
     *
     * @return $resultPage
     */
    public function execute()
    {
        $resultPage = $this->_pageFactory->create();

        $preorder_data = $this->getRequest()->getParams();

        $type     = $preorder_data['type'];

        $to       = $preorder_data['email'];

        $connection  = $this->resource->getConnection();

        $frontName   = $this->_deploymentConfig->get('backend/frontName');

        if ($type==2) {
            $data = ["status"=>2];
            $send_message_attribute = "cancelled";
            $send_message_attribute_c = "inform";
        } elseif ($type==1) {
            $data = ["status"=>1];
            $send_message_attribute = "approved";
            $send_message_attribute_c = "confirm";
        } else {
            $data = ["status"=>0];
            $send_message_attribute = "pending";
        }
                
        $id = $preorder_data['preorder_id'];

        $sku = strip_tags($preorder_data['sku']);

        $product = $preorder_data['product'];

        $setData = ['send_message_attribute_c'=>$send_message_attribute_c,
            'send_message_attribute'=>$send_message_attribute,
            'sku'=>$sku,'product'=>$product,"status"=>$data['status']];

        $block = $resultPage->getLayout()
                    ->createBlock(\Preorder\Module\Block\Emailblock::class)
                    ->setTemplate('Preorder_Module::email_template.phtml')
                    ->setData('data', $setData)
                    ->toHtml();
              
        $where = ['preorder_id = ?' => (int)$id];
        
        $tableName = $connection->getTableName(self::QUOTE_TABLE);
        
        $updatedRows = $connection->update($tableName, $data, $where);
        
        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
      
        $this->_helper->sendMail($to, $to, $block, $type);

        $storeManager = $objectManager->get(\Magento\Store\Model\StoreManagerInterface::class);

        $baseurl = $storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB).$frontName."/";
        
        $redirect->setUrl($baseurl.'preorder_grid/action/indexx');
        
        $this->messageManager->addSuccess(__('Preorder status mail sent successfully'));

        return $redirect;
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
