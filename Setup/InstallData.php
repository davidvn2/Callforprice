<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Setup;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface {
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
	/**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
	private $categorySetupFactory;
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory,CategorySetupFactory $categorySetupFactory) {
        $this->eavSetupFactory = $eavSetupFactory;
		$this->categorySetupFactory = $categorySetupFactory;
    }
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY, 'call_for_price_active', [
            'group' => 'Product Details',
            'type' => 'int',
            'sort_order' => 100,
            'backend' => '',
            'frontend' => '',
            'label' => 'Set call for price',
            'input' => 'boolean',
            'class' => '',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false,
            'apply_to' => 'simple,configurable,virtual,bundle,downloadable,grouped'
        ]);
		/** @var categorySetupFactory $categorySetup */
		$installer = $setup;
        $installer->startSetup();
		$categoryCode = "call_for_price_active";
		// create attribute of category
		$categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        $categorySetup->removeAttribute(
			\Magento\Catalog\Model\Category::ENTITY, $categoryCode
		);
        $categorySetup->addAttribute(
			\Magento\Catalog\Model\Category::ENTITY, $categoryCode, [
				 'type' => 'int',
				 'label' => 'Set call for price',
				 'input' => 'boolean',
				 'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
				 'required' => false,
				 'default' => '',
				 'sort_order' => 100,
				 'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
				 'group' => 'General Information',
			]
		);
		$idg =  $categorySetup->getAttributeGroupId($entityTypeId, $attributeSetId, 'General Information');
		$categorySetup->addAttributeToGroup(
			$entityTypeId,
			$attributeSetId,
			$idg,
			$categoryCode,
			60
		);
		$installer->endSetup();
    }
}