<?php

/**
 * Preorder Module Helper Email
 */

namespace Preorder\Module\Helper;

use Magento\Store\Model\Store;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Message\ManagerInterface; 
use Magento\Framework\App\Helper\AbstractHelper;
/**
 * Class Mail
 * @package Preorder\Module\Helper
 */
class Email extends AbstractHelper
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;
    
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;
    /**
     *
     * @var ScopeConfigInterface 
     */
    protected $scopeConfig;

    /**
     * @param ScopeInterface $scopeConfig
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     */
    public function __construct(ScopeConfigInterface $scopeConfig,
            TransportBuilder $transportBuilder,
            StateInterface $inlineTranslation,
            ManagerInterface $messageManager
            )
    {
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->messageManager=$messageManager;
    }
    /**
     * Preorder Module @sendMail
     */
    public function sendMail($to, $name, $commented, $type)
    {
            $this->inlineTranslation->suspend();      
        
            try
            {
                 $admin=$this->scopeConfig->getValue('trans_email/ident_general/email', ScopeInterface::SCOPE_STORE);
                 $transport = $this->transportBuilder->setTemplateIdentifier('mail_template')
                    ->setTemplateOptions(['area'  => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => Store::DEFAULT_STORE_ID])
                    ->setTemplateVars([ 
                        'name'  => 'karthi',
                      'message' => $commented])
                    ->setFrom(['email' => 'karthikeyan3071997@gmail.com', 'name' => 'karthikeyan'])
                    ->addTo([$to])
                    ->addBcc('karthikeyan3071997@gmail.com')
                    ->getTransport();
            $transport->sendMessage();
            } finally
            {
                  $this->inlineTranslation->resume();
            }
        
    }
}
