<?php

namespace MagePsycho\ShipTo\Plugin\Model;

use MagePsycho\ShipTo\Helper\Data as ShipToHelper;
use MagePsycho\ShipTo\Model\CountryResolver;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class SetDefaultCountryPlugin
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

    public function aroundGetDefaultCountryId(
        \Amasty\Checkout\Model\Config $subject,
        callable $proceed
    ) {
        $this->shipToHelper->log(__METHOD__);
        if (!$this->shipToHelper->isActive()) {
            return $proceed();
        }
        return $this->countryResolver->getShipToCountryId();
    }
}
