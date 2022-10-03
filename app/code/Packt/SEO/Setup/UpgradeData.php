<?php

namespace Packt\SEO\Setup;

use Magento\Config\Block\System\Config\Form;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $resourceConfig;

    public function __construct(Config $resourceConfig)
    {
        $this->resourceConfig = $resourceConfig;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.1') < 0) {
            $this->resourceConfig->saveConfig('web/cookie/cookie_lifetime', '7200', Form::SCOPE_DEFAULT, 0);
        }
    }
}
