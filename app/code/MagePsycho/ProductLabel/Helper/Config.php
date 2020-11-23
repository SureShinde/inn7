<?php

namespace MagePsycho\ProductLabel\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ProductLabel
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Config
{
    const XML_PATH_ENABLED          = 'magepsycho_productlabel/general/enabled';
    const XML_PATH_DEBUG            = 'magepsycho_productlabel/general/debug';
    const XML_PATH_DISCOUNT_FORMAT  = 'magepsycho_productlabel/discount/format';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfigValue($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
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

    public function getDiscountDisplayFormat($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_DISCOUNT_FORMAT, $storeId);
    }
}
