<?php
namespace Packt\HelloWorld\Block\Adminhtml;
class Subscription extends
    \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Packt_HelloWorld';
        $this->_controller = 'adminhtml_subscription';
        parent::_construct();
    }
}
