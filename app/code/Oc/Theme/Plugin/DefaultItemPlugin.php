<?php

namespace Oc\Theme\Plugin;

class DefaultItemPlugin
{

    public function afterGetItemData(
        \Magento\Checkout\CustomerData\AbstractItem $subject,
        $result,
        \Magento\Quote\Model\Quote\Item $item)
    {
        $data['product_name_man'] = $item->getProduct()->getName().' - '.$item->getProduct()->getAttributeText('manufacturer');

        return \array_merge(
            $result,
            $data
        );
    }

}