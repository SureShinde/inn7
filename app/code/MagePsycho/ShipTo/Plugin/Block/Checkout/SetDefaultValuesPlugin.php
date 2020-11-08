<?php

namespace MagePsycho\ShipTo\Plugin\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use MagePsycho\ShipTo\Helper\Data as ShipToHelper;
use MagePsycho\ShipTo\Model\CountryResolver;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SetDefaultValuesPlugin
{
    /**
     * @var ShipToHelper
     */
    private $shipToHelper;

    /**
     * @var CountryResolver
     */
    private $countryResolver;

    public function __construct(
        ShipToHelper $shipToHelper,
        CountryResolver $countryResolver
    ) {
        $this->shipToHelper = $shipToHelper;
        $this->countryResolver = $countryResolver;
    }

    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ) {
        $this->shipToHelper->log(__METHOD__);
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']['value'] = $this->countryResolver->getShipToCountryId();

        return $jsLayout;
    }
}
