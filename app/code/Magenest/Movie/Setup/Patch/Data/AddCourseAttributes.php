<?php

namespace Magenest\Movie\Setup\Patch\Data;

use Magento\Catalog\Model\Attribute\Backend\Startdate;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Boolean;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCourseAttributes implements DataPatchInterface
{
    private $_moduleDataSetup;

    private $_eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory
    ) {
        $this->_moduleDataSetup = $moduleDataSetup;
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public static function getDependencies()
    {
        return [];
    }

    public static function getVersion()
    {
        return '1.0.0';
    }

    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $this->_moduleDataSetup]);

        $eavSetup->addAttribute(Product::ENTITY, 'start_date', [
            'type' => 'datetime',
            'label' => 'Start Date',
            'input_renderer' => 'Magenest\Movie\Ui\DataProvider\Product\Form\Modifier\DatetimeStart',
            'class' => 'validate-date',
            'input' => 'date',
            'backend' => Startdate::class,
            'required' => true,
            'sort_order' => 1,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'Course',
            'visible' => true,
            'used_in_product_listing' => true,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
        ]);

        $eavSetup->addAttribute(Product::ENTITY, 'end_date', [
            'type' => 'datetime',
            'label' => 'End Date',
            'input_renderer' => 'Magenest\Movie\Ui\DataProvider\Product\Form\Modifier\DatetimeEnd',
            'class' => 'validate-date',
            'input' => 'date',
            'backend' => Startdate::class,
            'required' => true,
            'sort_order' => 11,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'Course',
            'visible' => true,
            'used_in_product_listing' => true,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
        ]);

    }

    public function getAliases()
    {
        return [];
    }
}
