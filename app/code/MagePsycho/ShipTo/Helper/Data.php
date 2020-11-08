<?php

namespace MagePsycho\ShipTo\Helper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \MagePsycho\ShipTo\Logger\Logger
     */
    protected $moduleLogger;

    /**
     * @var \MagePsycho\ShipTo\Helper\Config
     */
    protected $configHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $moduleList;


    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \MagePsycho\ShipTo\Logger\Logger $moduleLogger,
        \MagePsycho\ShipTo\Helper\Config $configHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Module\ModuleListInterface $moduleList
    ) {
        $this->moduleLogger            = $moduleLogger;
        $this->configHelper            = $configHelper;
        $this->storeManager            = $storeManager;
        $this->moduleList              = $moduleList;

        parent::__construct($context);
    }


    public function getConfigHelper()
    {
        return $this->configHelper;
    }

    public function getExtensionVersion()
    {
        $moduleCode = 'MagePsycho_ShipTo';
        $moduleInfo = $this->moduleList->getOne($moduleCode);
        return $moduleInfo['setup_version'];
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_WEB,
            true
        );
    }

    public function isActive()
    {
        return $this->configHelper->isActive();
    }

    /**
     * Logging Utility
     *
     * @param $message
     * @param bool|false $useSeparator
     */
    public function log($message, $useSeparator = false)
    {
        if ($this->isActive()
            && $this->configHelper->getDebugStatus()
        ) {
            if ($useSeparator) {
                $this->moduleLogger->customLog(str_repeat('=', 100));
            }

            $this->moduleLogger->customLog($message);
        }
    }
}
