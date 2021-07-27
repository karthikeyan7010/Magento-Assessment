<?php

/**
 * Preorder Cancelled
 */

namespace Preorder\Module\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Cancel extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if($item['status']==2)
                {
                    $item[$fieldName . '_html'] = "<div><button class='secondary'><span>Mail Rejected</span></button></div>";    
                }
                else
                {
                    $item[$fieldName . '_html'] = "<div><button class='secondary'><span>Reject</span></button></div>";
                }

                $send_message  = "Your Product ".$item['product']." preorder is Rejected";
                $item[$fieldName . '_title'] = __('Mail Content');
                $item[$fieldName . '_submitlabel'] = __('Ok');
                $item[$fieldName . '_cancellabel'] = __('Reset');
                $item[$fieldName . '_customerid'] = $item['preorder_id'];
                $item[$fieldName . '_sku'] = $item['sku'];
                $item[$fieldName . '_product'] = $item['product'];
                $item[$fieldName . '_email'] = $item['email'];
                $item[$fieldName . '_type'] = 2;
                $item[$fieldName . '_comments'] = $send_message;
                $item[$fieldName . '_formaction'] = $this->urlBuilder->getUrl('preorder_grid/action/sendmaill');
            }
        }
        return $dataSource;
    }
}
