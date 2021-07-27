<?php

/**
 * Preorder Module Params Get
 */

namespace Preorder\Module\Block;

class Display extends \Magento\Framework\View\Element\Template
{
    public $_redirect;
        
    protected $_customerSession;
    private $productRepository; 

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Response\Http $redirect,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->_redirect = $redirect;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }
    
    public function getParams()
    {
        $data = $this->getRequest()->getParams();
        
        $proSku = $data['sku'];
        $product = $this->productRepository->get($proSku);
        
        return $product;
    }
    
    public function redirect()
    {
        return $this->_redirect;
    }
    
    public function userdata()
    {
        return $this->_customerSession;
    }
}
