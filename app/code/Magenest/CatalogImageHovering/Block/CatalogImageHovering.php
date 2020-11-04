<?php

namespace Magenest\CatalogImageHovering\Block;

use Magenest\CatalogImageHovering\Model\Config\Source\HoverElement;
use Magento\Framework\View\Element\Template;
use Magenest\CatalogImageHovering\Model\Config\Source\Animation;

class CatalogImageHovering extends Template
{
    const XML_PATH_MODULE_ENABLED = 'catalog_image_hovering/general/enabled';
    const XML_PATH_ANIMATION_CONFIGURATION = 'catalog_image_hovering/general/animation';
    const XML_PATH_TRANSITION_DURATION = 'catalog_image_hovering/general/duration';
    const XML_PATH_EASING_FUNCTION = 'catalog_image_hovering/general/easing_function';
    const XML_PATH_HOVER_ELEMENT = 'catalog_image_hovering/general/hover_element';

    const ANIMATION_JS_NAME_IMMEDIATELY = 'immediate';
    const ANIMATION_JS_NAME_FADE_INTO = 'fade_into';
    const ANIMATION_JS_NAME_TRANSITION_LEFT_TO_RIGHT = 'left_to_right';
    const ANIMATION_JS_NAME_TRANSITION_RIGHT_TO_LEFT = 'right_to_left';
    const ANIMATION_JS_NAME_TRANSITION_BOTTOM_TO_TOP = 'bottom_to_top';
    const ANIMATION_JS_NAME_TRANSITION_TOP_TO_BOTTOM = 'top_to_bottom';

    const HOVER_ELEMENT_IMAGE = '.product-image-wrapper';
    const HOVER_ELEMENT_PRODUCT = '.product-item-info';

    /**
     * @var \Magenest\CatalogImageHovering\Helper\Data
     */
    protected $helper;

    /**
     * CatalogImageHovering constructor.
     * @param Template\Context $context
     * @param \Magenest\CatalogImageHovering\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magenest\CatalogImageHovering\Helper\Data $helper,
        array $data = []
    )
    {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Get animation js file name
     *
     * @return string
     */
    public function getAnimationJsName() {
        $animationIndex = $this->helper->getConfigValue(self::XML_PATH_ANIMATION_CONFIGURATION);

        switch ($animationIndex) {
            case Animation::ANIMATION_INDEX_FADE_INTO:
                return self::ANIMATION_JS_NAME_FADE_INTO;
                break;
            case Animation::ANIMATION_INDEX_TRANSITION_LEFT_TO_RIGHT:
                return self::ANIMATION_JS_NAME_TRANSITION_LEFT_TO_RIGHT;
                break;
            case Animation::ANIMATION_INDEX_TRANSITION_RIGHT_TO_LEFT:
                return self::ANIMATION_JS_NAME_TRANSITION_RIGHT_TO_LEFT;
                break;
            case Animation::ANIMATION_INDEX_TRANSITION_BOTTOM_TO_TOP:
                return self::ANIMATION_JS_NAME_TRANSITION_BOTTOM_TO_TOP;
                break;
            case Animation::ANIMATION_INDEX_TRANSITION_TOP_TO_BOTTOM:
                return self::ANIMATION_JS_NAME_TRANSITION_TOP_TO_BOTTOM;
                break;
            default:
                return self::ANIMATION_JS_NAME_IMMEDIATELY;
                break;
        }
    }

    /**
     * Get transition duration
     *
     * @return mixed
     */
    public function getDuration() {
        $result = $this->helper->getConfigValue(self::XML_PATH_TRANSITION_DURATION);
        if (empty($result))
            $result = 0;
        else
            $result = trim($result)*1;

        return $result;
    }

    /**
     * Get easing function for transition
     *
     * @return mixed
     */
    public function getEasingFunction() {
        return $this->helper->getConfigValue(self::XML_PATH_EASING_FUNCTION);
    }

    /**
     * Get easing function for transition
     *
     * @return mixed
     */
    public function getHoverElement() {
        $hoverElement =  $this->helper->getConfigValue(self::XML_PATH_HOVER_ELEMENT);
        switch ($hoverElement) {
            case HoverElement::HOVER_ON_IMAGE:
                return self::HOVER_ELEMENT_IMAGE;
                break;
            case HoverElement::HOVER_ON_PRODUCT:
                return self::HOVER_ELEMENT_PRODUCT;
                break;
            default:
                return self::HOVER_ELEMENT_IMAGE;
                break;
        }
    }
}