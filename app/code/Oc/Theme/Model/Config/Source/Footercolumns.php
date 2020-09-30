<?php
namespace Oc\Theme\Model\Config\Source;
class Footercolumns implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return array(
            array('value' => '1', 'label' => '1'),
            array('value' => '2', 'label' => '2'),
			array('value' => '3', 'label' => '3'),
			array('value' => '4', 'label' => '4')
        );
    }
}