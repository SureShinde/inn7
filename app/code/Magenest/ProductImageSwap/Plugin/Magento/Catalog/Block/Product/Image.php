<?php
namespace Magenest\ProductImageSwap\Plugin\Magento\Catalog\Block\Product;


class Image
{
    public function afterEscapeHtmlAttr($subject, $result, $string)
    {
        if(strpos($string, 'data-catalog_image_hovering') !== false)
            $result =  $string;
        return $result;
    }
}