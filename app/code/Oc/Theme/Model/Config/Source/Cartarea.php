<?php
namespace Oc\Theme\Model\Config\Source;
class Cartarea implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return array(
            array('value' => '0',    'label' => 'Disable'),
            array('value' => '1',    'label' => 'Only button'),
			array('value' => '2',    'label' => 'Button with Count field')
        );
    }
}