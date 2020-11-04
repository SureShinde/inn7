<?php

namespace Magenest\ProductImageSwap\Model\Config\Source;

/**
 * Class HoverElement
 * @package Magenest\ProductImageSwap\Model\Config\Source
 */
class HoverElement implements \Magento\Framework\Option\ArrayInterface
{
    const HOVER_ON_IMAGE = 'image';
    const HOVER_ON_PRODUCT = 'product';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::HOVER_ON_IMAGE,
                'label' => __('Product Image')
            ],
            [
                'value' => self::HOVER_ON_PRODUCT,
                'label' => __('Product Container')
            ]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::HOVER_ON_IMAGE => __('Image'),
            self::HOVER_ON_PRODUCT => __('Product'),
        ];
    }
}
