<?php

namespace Packt\SEO\Setup;

use Magento\Config\Block\System\Config\Form;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $resourceConfig;

    public function __construct(Config $resourceConfig)
    {
        $this->resourceConfig = $resourceConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->resourceConfig->saveConfig('catalog/seo/category_canonical_tag', true, Form::SCOPE_DEFAULT, 0);
        $this->resourceConfig->saveConfig('catalog/seo/product_canonical_tag', true, Form::SCOPE_DEFAULT, 0);
        $setup->endSetup();
    }
}
