<?php

namespace Magenest\CatalogImageHovering\Plugin\Magento\Catalog\Block\Product;

class ImageFactory
{
    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magenest\CatalogImageHovering\Helper\Data
     */
    protected $helper;

    /**
     * ImageFactory constructor.
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magenest\CatalogImageHovering\Helper\Data $helper
     */
    public function __construct(
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magenest\CatalogImageHovering\Helper\Data $helper
    )
    {
        $this->imageHelper = $imageHelper;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Catalog\Block\Product\ImageFactory $subject
     * @param null $product
     * @param null $imageId
     * @param null $attributes
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeCreate(\Magento\Catalog\Block\Product\ImageFactory $subject, $product = null, $imageId = null, $attributes = null)
    {
        if ($this->helper->isEnabled() && $this->helper->getMagentoVersion() >= '2.3') {
            if ($product !== null && $imageId !== null) {
                $this->imageHelper->init($product, $imageId);
                $imageType = $this->imageHelper->getType();
                $baseImagePath = $product->getData($imageType);

                if ($baseImagePath && $baseImagePath !== 'no_selection') {
                    $catalogImageHovering = $product->getCatalogImageHovering();

                    if ($this->helper->isTmpPath($catalogImageHovering)) $catalogImageHovering = '';

                    if ((!$catalogImageHovering || $catalogImageHovering === "no_selection") &&
                        $this->helper->isDefaultHoveredEnabled()
                    ) {
                        $image = $this->helper->getCatalogHoveringImage($product->getEntityId(), $baseImagePath);
                        if ($image) $catalogImageHovering = $image;
                    }

                    if ($catalogImageHovering && $catalogImageHovering !== "no_selection" && $baseImagePath !== $catalogImageHovering) {
                        $hoveringImageUrl = $this->imageHelper->init($product, $imageId)
                            ->setImageFile($catalogImageHovering)
                            ->getUrl();

                        $data = [
                            'data-catalog_image_hovering' => $hoveringImageUrl,
                            'data-original_category_image' => '',
                        ];
                        if (empty($attributes)) $attributes = [];
                        $attributes = array_merge($attributes, $data);
                    }
                }
            }
        }

        return [$product, $imageId, $attributes];
    }
}