<?php

namespace MagePsycho\ShipTo\Helper\Preference\Directory;

use Magento\Directory\Model\CurrencyFactory;
use Magento\Directory\Model\ResourceModel\Country\Collection;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Cache\Type\Config;
use Magento\Framework\Json\Helper\Data as JsonData;
use Magento\Store\Model\StoreManagerInterface;
use MagePsycho\ShipTo\Helper\Data as ShipToHelper;
use MagePsycho\ShipTo\Model\CountryResolver;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Data extends \Magento\Directory\Helper\Data
{
    /**
     * @var ShipToHelper
     */
    private $shipToHelper;

    /**
     * @var CountryResolver
     */
    private $countryResolver;

    /**
     * @var string|null|false
     */
    private $country;

    public function __construct(
        Context $context,
        Config $configCacheType,
        Collection $countryCollection,
        CollectionFactory $regCollectionFactory,
        JsonData $jsonHelper,
        StoreManagerInterface $storeManager,
        CurrencyFactory $currencyFactory,
        ShipToHelper $shipToHelper,
        CountryResolver $countryResolver
    ) {
        parent::__construct(
            $context,
            $configCacheType,
            $countryCollection,
            $regCollectionFactory,
            $jsonHelper,
            $storeManager,
            $currencyFactory
        );
        $this->shipToHelper = $shipToHelper;
        $this->countryResolver = $countryResolver;
    }

    /**
     * We prefer not to use a preference for this, but we're not allowed to create a plugin
     * for Magento\Directory\Helper\Data because it's a virtual type.
     *
     * We also can't use a plugin on Magento\Checkout\Block\Checkout\AttributeMerger::getDefaultValue because
     * it's protected, also it would miss a couple of other getDefaultCountry() calls.
     *
     * @param int|null $store
     * @return string
     */
    public function getDefaultCountry($store = null)
    {
        #$this->shipToHelper->log(__METHOD__);
        /**
         * null  = not cached
         * false = couldn't get country from ship to
         */
        if ($store === null && $this->country === null) {
            $country = $this->countryResolver->getShipToCountryId();
            $this->country = $country !== null ? $country : false;
        }
        return $this->country ? $this->country : parent::getDefaultCountry($store);
    }
}
