<?php

namespace MagePsycho\ShipTo\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use MagePsycho\ShipTo\Model\CountryResolver;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Shipto implements SectionSourceInterface
{
    /**
     * @var CountryResolver
     */
    private $countryResolver;

    public function __construct(
        CountryResolver $countryResolver
    ) {
        $this->countryResolver = $countryResolver;
    }

    public function getSectionData()
    {
        $countryInfo = $this->countryResolver->getShipToCountryInfo();
        return [
            'country' => $countryInfo['name'],
            'country_id' => $countryInfo['id']
        ];
    }
}
