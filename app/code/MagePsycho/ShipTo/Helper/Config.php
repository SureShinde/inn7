<?php

namespace MagePsycho\ShipTo\Helper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Config
{
    const XML_PATH_ENABLED          = 'magepsycho_shipto/general/enabled';
    const XML_PATH_DEBUG            = 'magepsycho_shipto/general/debug';
    const XML_PATH_DEFAULT_COUNTRY  = 'general/country/default';
    const XML_PATH_DEFAULT_TAX_COUNTRY = 'tax/defaults/country';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfigValue($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $xmlPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function isEnabled($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_ENABLED, $storeId);
    }

    public function isActive($storeId = null)
    {
        return $this->isEnabled($storeId);
    }

    public function getDebugStatus($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_DEBUG, $storeId);
    }

    public function getDefaultCountryId($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_DEFAULT_COUNTRY, $storeId);
    }
}
