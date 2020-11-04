<?php

namespace Magenest\ProductImageSwap\Model\Config\Source;

/**
 * Class Animation
 * @package Magenest\ProductImageSwap\Model\Config\Source
 */
class Animation implements \Magento\Framework\Option\ArrayInterface
{
    const ANIMATION_INDEX_IMMEDIATELY = 0;
    const ANIMATION_INDEX_FADE_INTO = 1;
    const ANIMATION_INDEX_TRANSITION_LEFT_TO_RIGHT = 2;
    const ANIMATION_INDEX_TRANSITION_RIGHT_TO_LEFT = 3;
    const ANIMATION_INDEX_TRANSITION_BOTTOM_TO_TOP = 4;
    const ANIMATION_INDEX_TRANSITION_TOP_TO_BOTTOM = 5;
    
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::ANIMATION_INDEX_IMMEDIATELY,
                'label' => __('No Animation')
            ],
            [
                'value' => self::ANIMATION_INDEX_FADE_INTO,
                'label' => __('Fade Into')
            ],
            [
                'value' => self::ANIMATION_INDEX_TRANSITION_LEFT_TO_RIGHT,
                'label' => __('Transition Left To Right')
            ],
            [
                'value' => self::ANIMATION_INDEX_TRANSITION_RIGHT_TO_LEFT,
                'label' => __('Transition Right To Left')
            ],
            [
                'value' => self::ANIMATION_INDEX_TRANSITION_BOTTOM_TO_TOP,
                'label' => __('Transition Bottom To Top')
            ],
            [
                'value' => self::ANIMATION_INDEX_TRANSITION_TOP_TO_BOTTOM,
                'label' => __('Transition Top To Bottom')
            ],
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
            self::ANIMATION_INDEX_IMMEDIATELY => __('No Animation'),
            self::ANIMATION_INDEX_FADE_INTO => __('Fade Into'),
            self::ANIMATION_INDEX_TRANSITION_LEFT_TO_RIGHT => __('Transition Left To Right'),
            self::ANIMATION_INDEX_TRANSITION_RIGHT_TO_LEFT => __('Transition Right To Left'),
            self::ANIMATION_INDEX_TRANSITION_BOTTOM_TO_TOP => __('Transition Bottom To Top'),
            self::ANIMATION_INDEX_TRANSITION_TOP_TO_BOTTOM => __('Transition Top To Bottom'),
        ];
    }
}
