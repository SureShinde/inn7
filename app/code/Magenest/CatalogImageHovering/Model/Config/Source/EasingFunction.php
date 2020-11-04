<?php

namespace Magenest\CatalogImageHovering\Model\Config\Source;

/**
 * Class EasingFunction
 * @package Magenest\CatalogImageHovering\Model\Config\Source
 */
class EasingFunction implements \Magento\Framework\Option\ArrayInterface
{
    const EASING_FUNCTION_EASE_IN_OUT = 'ease-in-out';
    const EASING_FUNCTION_EASE_IN = 'ease-in';
    const EASING_FUNCTION_EASE_OUT = 'ease-out';
    const EASING_FUNCTION_LINEAR = 'linear';
    const EASING_FUNCTION_EASE = 'ease';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::EASING_FUNCTION_EASE_IN_OUT,
                'label' => __('Ease In Out')
            ],
            [
                'value' => self::EASING_FUNCTION_EASE_IN,
                'label' => __('Ease In')
            ],
            [
                'value' => self::EASING_FUNCTION_EASE_OUT,
                'label' => __('Ease Out')
            ],
            [
                'value' => self::EASING_FUNCTION_LINEAR,
                'label' => __('Linear')
            ],
            [
                'value' => self::EASING_FUNCTION_EASE,
                'label' => __('Ease')
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
            self::EASING_FUNCTION_EASE_IN_OUT => __('Ease In Out'),
            self::EASING_FUNCTION_EASE_IN => __('Ease In'),
            self::EASING_FUNCTION_EASE_OUT => __('Ease Out'),
            self::EASING_FUNCTION_LINEAR => __('Linear'),
            self::EASING_FUNCTION_EASE => __('Ease'),
        ];
    }
}
