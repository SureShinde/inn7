<?php
namespace Oc\Theme\Model\Config\Source;
class Size implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return array(
            array('value' => '10px',    'label' => '10 px'),
            array('value' => '11px',    'label' => '11 px'),
			array('value' => '12px',	'label' => '12 px'),
			array('value' => '13px',	'label' => '13 px'),
            array('value' => '14px',    'label' => '14 px'),
            array('value' => '15px',    'label' => '15 px'),
            array('value' => '16px',    'label' => '16 px'),
            array('value' => '17px',    'label' => '17 px'),
            array('value' => '18px',	'label' => '18 px'),
			array('value' => '19px',	'label' => '19 px'),
			array('value' => '20px',	'label' => '20 px')
        );
    }
}