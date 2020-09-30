<?php
namespace Webkul\MiniCart\Plugin\Checkout\CustomerData;

class Cart {
    public function afterGetSectionData(\Magento\Checkout\CustomerData\Cart $subject, array $result)
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORES;
		$confTwo = (float)$objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('carriers/freeshipping/free_shipping_subtotal',$storeScope);
		$minus=$confTwo-$result['subtotalAmount'];
		if($result['subtotalAmount']>=$confTwo){
			$result['extra_data'] = __('You are eligible for free shipping');
		}else
		{
			$result['extra_data'] = __('You are short with').' <span>'.$minus.'</span> '.__('for free shipping').'!';
		}
        
        return $result;
    }
}