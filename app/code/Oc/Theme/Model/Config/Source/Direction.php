<?php
namespace Oc\Theme\Model\Config\Source;
class Direction implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return array(
            array('value' => 'rtl',    'label' => 'Right to Left'),
            array('value' => 'ltr',    'label' => 'Left to Right')
        );
    }
}