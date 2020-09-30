<?php
namespace Oc\Theme\Model\Config\Source;
class Menuhovertype implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('All link area background color')],
            ['value' => 1, 'label' => __('Under line')],
            ['value' => 2, 'label' => __('Bottom Line')],
			['value' => 3, 'label' => __('None')]
        ];
    }
}