<?php

namespace Magenest\CatalogImageHovering\Plugin\Magento\Catalog\Block\Product;

class ImageBuilder
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magenest\CatalogImageHovering\Helper\Data
     */
    protected $helper;

    /**
     * ImageBuilder constructor.
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magenest\CatalogImageHovering\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magenest\CatalogImageHovering\Helper\Data $helper
    )
    {
        $this->registry = $registry;
        $this->imageHelper = $imageHelper;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Catalog\Block\Product\ImageBuilder $subject
     * @param $product
     * @return array
     */
    public function beforeSetProduct(\Magento\Catalog\Block\Product\ImageBuilder $subject, $product)
    {
        if ($this->helper->isEnabled() && $this->helper->getMagentoVersion() < '2.3') {
            $registry = $this->registry;

            if ($registry->registry('data-catalog_category_product', $product))
                $registry->unregister('data-catalog_category_product');
            $registry->register('data-catalog_category_product', $product);
        }

        return [$product];
    }

    /**
     * @param \Magento\Catalog\Block\Product\ImageBuilder $subject
     * @param $imageId
     * @return array
     */
    public function beforeSetImageId(\Magento\Catalog\Block\Product\ImageBuilder $subject, $imageId)
    {
        if ($this->helper->isEnabled() && $this->helper->getMagentoVersion() < '2.3') {
            $registry = $this->registry;
            $product = $registry->registry('data-catalog_category_product');
            if ($product !== null) {
                if ($registry->registry('data-category_image_id'))
                    $registry->unregister('data-category_image_id');
                $registry->register('data-category_image_id', $imageId);
            }
        }

        return [$imageId];
    }


    /**
     * @param \Magento\Catalog\Block\Product\ImageBuilder $subject
     * @param $attributes
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSetAttributes(\Magento\Catalog\Block\Product\ImageBuilder $subject, $attributes)
    {
        if ($this->helper->isEnabled() && $this->helper->getMagentoVersion() < '2.3') {
            $registry = $this->registry;
            $product = $registry->registry('data-catalog_category_product');
            $imageId = $registry->registry('data-category_image_id');

            if ($product !== null && $imageId) {

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
                        $attributes = array_merge($attributes, $data);
                    }
                }
            }

            $registry->unregister('data-catalog_category_product');
            $registry->unregister('data-category_image_id');

            if (empty($attributes)) $attributes['no_hovered'] = '1';
        }

        return [$attributes];
    }

    /**
     * @param \Magento\Catalog\Block\Product\ImageBuilder $subject
     * @param $result
     * @return mixed
     */
    public function afterCreate(\Magento\Catalog\Block\Product\ImageBuilder $subject, $result) {
        if ($this->helper->isEnabled() && $this->helper->getMagentoVersion() < '2.3') {
            if (isset($result['custom_attributes'])) {
                $attributes = [];
                $array = explode(' ', $result['custom_attributes']);
                foreach ($array as $key => $value) {
                    $attribute = explode('=', $value);
                    if ($attribute[0] === 'data-catalog_image_hovering' || $attribute[0] === 'data-original_category_image')
                        continue;
                    $attributes[] = $attribute[1];
                }

                $subject->setAttributes($attributes);
            }
        }

        return $result;
    }

}