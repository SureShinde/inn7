<?php

namespace Magenest\CatalogImageHovering\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    const XML_PATH_CATALOG_IMAGE_HOVERING_GENERAL_ENABLED = 'catalog_image_hovering/general/enabled';
    const XML_CATALOG_IMAGE_HOVERING_GENERAL_DEFAULT      = 'catalog_image_hovering/general/default';

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * Data constructor.
     * @param Context $context
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
        Context $context,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->productMetadata = $productMetadata;
        $this->storeManager    = $storeManager;
        $this->resource        = $resource;
    }

    /**
     * Get configuration value
     *
     * @param $path
     * @return mixed
     */
    public function getConfigValue($path)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if extension is enabled
     *
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CATALOG_IMAGE_HOVERING_GENERAL_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get magento 2 version
     *
     * @return string
     */
    public function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }

    /**
     * Get catalog image hovering path
     *
     * @param $productId
     * @param $baseImagePath
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCatalogHoveringImage($productId, $baseImagePath)
    {
        $connection                                 = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $catalogProductEntityMediaGalleryValueTable = $this->resource->getTableName('catalog_product_entity_media_gallery_value');
        $catalogProductEntityMediaGalleryTable      = $this->resource->getTableName('catalog_product_entity_media_gallery');

        $storeId = $this->storeManager->getStore()->getStoreId();

        $column = $this->resource->getConnection()->tableColumnExists($catalogProductEntityMediaGalleryValueTable, 'row_id') ? 'row_id' : 'entity_id';
        $select = $connection->select()->from(['g_v' => $catalogProductEntityMediaGalleryValueTable], '')
            ->join(
                ['g' => $catalogProductEntityMediaGalleryTable],
                'g_v.value_id = g.value_id',
                'g.value'
            )
            ->where('g_v.' . $column . ' = ?', $productId)
            ->order('g_v.position');

        $select1 = clone $select;
        $select1->where('g_v.store_id = ?', $storeId);

        $result = $connection->fetchCol($select1);

        $result = $this->getFirstDiff($result, $baseImagePath);

        if (empty($result)) {
            $select2 = clone $select;
            $select2->where('g_v.store_id = ?', 0);
            $result = $connection->fetchCol($select2);
            $result = $this->getFirstDiff($result, $baseImagePath);
        }

        if (!empty($result)) {
            return $result;
        }

        return null;
    }

    /**
     * Get the first different element in array compared with searched element
     *
     * @param $array
     * @param $search
     * @return string|null
     */
    public function getFirstDiff($array, $search)
    {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                if ($value !== $search) {
                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * Check if Default hovered image option is enabled
     *
     * @return mixed
     */
    public function isDefaultHoveredEnabled()
    {
        return $this->getConfigValue(self::XML_CATALOG_IMAGE_HOVERING_GENERAL_DEFAULT);
    }

    /**
     * Check if the path is .tmp or not
     *
     * @param $path
     * @return bool
     */
    public function isTmpPath($path)
    {
        return strpos($path, '.tmp') !== false && strrpos($path, '.tmp') == strlen($path) - 4;
    }
}
