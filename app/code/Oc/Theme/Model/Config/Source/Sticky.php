<?php
namespace Oc\Theme\Model\Config\Source;
class Sticky implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('No')],
            ['value' => 1, 'label' => __('All Header')],
            ['value' => 2, 'label' => __('Main Header (logo & menu)')],
            ['value' => 3, 'label' => __('Only Menu')]
        ];
    }
}