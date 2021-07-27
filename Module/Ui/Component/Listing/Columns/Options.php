<?php

/**
 * Preorder Options
 */

namespace Preorder\Module\Ui\Component\Listing\Columns;

class Options implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Pending')],
            ['value' => 1, 'label' => __('Approved')],
            ['value' => 2, 'label' => __('Rejected')]
        ];
    }
}
