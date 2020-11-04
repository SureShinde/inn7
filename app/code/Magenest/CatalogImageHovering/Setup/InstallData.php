<?php

namespace Magenest\CatalogImageHovering\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\State;

/**
 * Class InstallData
 * @package Magenest\CatalogImageHovering\Setup
 */
class InstallData implements InstallDataInterface
{
    const ATTRIBUTE_CATALOG_IMAGE_HOVERING = 'catalog_image_hovering';

    /**
     * @var EavSetupFactory 
     */
    private $eavSetupFactory;

    /**
     * @var \Magento\Eav\Api\AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * @var State
     */
    private $state;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param State $state
     * @param \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        State $state,
        \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeRepository = $attributeRepository;
        $this->state = $state;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Exception
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->state->emulateAreaCode(
            'global',
            function ($setup) {
                $this->createAttributeImageHovering($setup);
            },
            [$setup]
        );

        $setup->endSetup();
    }

    /**
     * Create attribute image hovering
     *
     * @param $setup
     */
    private function createAttributeImageHovering($setup) {
        try {
            $attribute = $this->attributeRepository->get(\Magento\Catalog\Model\Product::ENTITY, self::ATTRIBUTE_CATALOG_IMAGE_HOVERING);

        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            /**
             * Add attributes to the eav/attribute
             */
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'catalog_image_hovering',
                [
                    'type' => 'varchar',
                    'label' => 'Hovered',
                    'input' => 'media_image',
                    'frontend' => \Magento\Catalog\Model\Product\Attribute\Frontend\Image::class,
                    'required' => false,
                    'sort_order' => 10,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'used_in_product_listing' => true,
                ]
            );
        }
    }

}