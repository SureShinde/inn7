<?php

namespace MagePsycho\ShipTo\Plugin\Model\Tax;

use MagePsycho\ShipTo\Helper\Data as ShipToHelper;
use MagePsycho\ShipTo\Model\CountryResolver;
use Magento\Tax\Model\TaxConfigProvider;

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

    public function aroundGetConfig(
        TaxConfigProvider $subject,
        callable $proceed
    ) {
        $this->shipToHelper->log(__METHOD__);
        if (!$this->shipToHelper->isActive()) {
            return $proceed();
        }

        $config = $proceed();
        $countryId = $this->countryResolver->getShipToCountryId();
        if ($countryId !== null) {
            $config['defaultCountryId'] = $countryId;
        }
        return $config;
    }
}
