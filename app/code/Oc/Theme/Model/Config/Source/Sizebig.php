<?php
namespace Oc\Theme\Model\Config\Source;
class Sizebig implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return array(
            array('value' => '14px',    'label' => '14px'),
            array('value' => '15px',    'label' => '15px'),
			array('value' => '16px',	'label' => '16px'),
			array('value' => '17px',	'label' => '17px'),
            array('value' => '18px',    'label' => '18px'),
            array('value' => '19px',    'label' => '19px'),
            array('value' => '20px',    'label' => '20px'),
            array('value' => '21px',    'label' => '21px'),
            array('value' => '22px',	'label' => '22px'),
            array('value' => '23px',	'label' => '23px'),
            array('value' => '24px',	'label' => '24px'),
            array('value' => '25px',	'label' => '25px'),
            array('value' => '26px',	'label' => '26px'),
            array('value' => '27px',	'label' => '27px'),
            array('value' => '28px',	'label' => '28px'),
            array('value' => '29px',	'label' => '29px'),
            array('value' => '30px',	'label' => '30px')			
        );
    }
}