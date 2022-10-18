<?php

namespace Magenest\Movie\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ReloadPage extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $html = '<button onclick="Window.location.reload()">Reload</button>';

        return $html;
    }

}



