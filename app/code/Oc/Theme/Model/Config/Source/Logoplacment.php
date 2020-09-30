<?php
namespace Oc\Theme\Model\Config\Source;
class Logoplacment implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'center', 'label' => __('Center')],
			['value' => 'left', 'label' => __('Left')],
			['value' => 'right', 'label' => __('Right')]
        ];
    }
}