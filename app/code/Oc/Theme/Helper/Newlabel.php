<?php

namespace Oc\Theme\Helper;

use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Newlabel extends \Magento\Framework\Url\Helper\Data
{

    /**
     * @var TimezoneInterface
     */
    protected $localeDate;

    public function __construct(
        TimezoneInterface $localeDate
    ) {
        $this->localeDate = $localeDate;
    }

    public function isProductNew($product)
    {
        $newsFromDate = $product->getNewsFromDate();
        $newsToDate = $product->getNewsToDate();
        if (!$newsFromDate && !$newsToDate) {
            return false;
        }

        return $this->localeDate->isScopeDateInInterval(
            $product->getStore(),
            $newsFromDate,
            $newsToDate
        );
    }
	
    public function isSaleLabel($product)
    {
		if($product->getSaleLabel())
			return true;
		else
			return false;
    }

    public function isOnSale($product)
    {
		$SpecialPrice = $product->getPriceInfo()->getPrice('special_price')->getValue();
		if($SpecialPrice)
			return true;
		else
			return false;			
	}		
}