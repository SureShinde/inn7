<?php

namespace MagePsycho\ShipTo\Block;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePsycho\ShipTo\Helper\Data as ShipToHelper;
use MagePsycho\ShipTo\Model\CountryResolver;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Popup extends Template
{
    /**
     * @var array
     */
    protected $jsLayout;

    /**
     * @var JsonSerializer
     */
    protected $jsonSerializer;

    /**
     * @var ShipToHelper
     */
    protected $ctvShipToHelper;

    /**
     * @var CountryResolver
     */
    protected $countryResolver;

    public function __construct(
        Context $context,
        ShipToHelper $ctvShipToHelper,
        CountryResolver $countryResolver,
        array $data = [],
        JsonSerializer $jsonSerializer = null
    ) {
        parent::__construct($context, $data);
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->jsonSerializer = $jsonSerializer ?: ObjectManager::getInstance()
            ->get(JsonSerializer::class);
        $this->ctvShipToHelper = $ctvShipToHelper;
        $this->countryResolver = $countryResolver;
    }

    /**
     * @return string
     */
    public function getJsLayout()
    {
        return \Zend_Json::encode($this->jsLayout);
    }

    /**
     * Returns popup config
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            'baseUrl'               => $this->getBaseUrl(),
            'isActive'              => $this->isActive(),
            'allowedCountries'      => $this->countryResolver->getAllowedCountryOptions()
        ];
    }

    /**
     * Return base url.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function isActive()
    {
        return (int)$this->ctvShipToHelper->isActive();
    }

    public function getSerializedConfig()
    {
        return $this->jsonSerializer->serialize($this->getConfig());
    }
}
