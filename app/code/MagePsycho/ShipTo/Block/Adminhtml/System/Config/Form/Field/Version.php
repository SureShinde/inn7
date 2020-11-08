<?php

namespace MagePsycho\ShipTo\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * @category   MagePsycho
 * @package    MagePsycho_ShipTo
 * @author     Raj KB <magepsycho@gmail.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Version extends \Magento\Config\Block\System\Config\Form\Field
{
    const EXTENSION_URL = 'https://www.magepsycho.com';

    /**
     * @var \MagePsycho\ShipTo\Helper\Data
     */
    protected $shipToHelper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \MagePsycho\ShipTo\Helper\Data $shipToHelper
    ) {
        $this->shipToHelper = $shipToHelper;
        parent::__construct($context);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $extensionVersion = $this->shipToHelper->getExtensionVersion();
        $extensionTitle   = 'Ship to Country';
        $versionLabel     = sprintf(
            '<a href="%s" title="%s" target="_blank">%s</a>',
            self::EXTENSION_URL,
            $extensionTitle,
            $extensionVersion
        );
        $element->setValue($versionLabel);

        return $element->getValue();
    }
}
