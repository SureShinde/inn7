<?php
namespace Oc\Theme\Plugin\Checkout\CustomerData;
class Cart
{
    protected $checkoutSession;
    protected $checkoutHelper;
    protected $quote;
	protected $helper;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Helper\Data $checkoutHelper,
		\Oc\Theme\Helper\Data $helper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->checkoutHelper = $checkoutHelper;
		$this->helper = $helper;
    }
    
    /**
     * Get active quote
     *
     * @return \Magento\Quote\Model\Quote
     */
    protected function getQuote()
    {
        if (null === $this->quote) {
            $this->quote = $this->checkoutSession->getQuote();
        }
        return $this->quote;
    }

    protected function getDiscountAmount()
    {
        $freeAmount = $this->helper('Oc\Theme\Helper\Data')->getConfig('oc_checkout/checkout/minimumshipping');
		$totals = $this->checkoutSession->getQuote()->getTotals();
        foreach($this->getQuote()->getAllVisibleItems() as $item){
            $discountAmount += ($item->getDiscountAmount() ? $item->getDiscountAmount() : 0);
        }
        return $freeAmount;
    }

    public function afterGetSectionData(\Magento\Checkout\CustomerData\Cart $subject, $result)
    {
        $result['discount_amount_no_html'] = -$this->getDiscountAmount();
        $result['shipping_left'] = -$this->getDiscountAmount();

        return $result;
    }
}