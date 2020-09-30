<?php
namespace Oc\Theme\Model\Config\Source;
class Mobilecount implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return array(
            array('value' => '1',    'label' => '1'),
            array('value' => '2',    'label' => '2')
        );
    }
}