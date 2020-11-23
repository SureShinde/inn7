<?php

namespace MagePsycho\ProductLabel\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Module\ModuleListInterface;
use MagePsycho\ProductLabel\Logger\Logger as ModuleLogger;
use \MagePsycho\ProductLabel\Helper\Config as ConfigHelper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ProductLabel
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Data extends AbstractHelper
{
    /**
     * @var ModuleLogger
     */
    protected $moduleLogger;

    /**
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ModuleListInterface
     */
    protected $moduleList;


    public function __construct(
        Context $context,
        ModuleLogger $moduleLogger,
        ConfigHelper $configHelper,
        StoreManagerInterface $storeManager,
        ModuleListInterface $moduleList
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
        $moduleCode = 'MagePsycho_ProductLabel';
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
