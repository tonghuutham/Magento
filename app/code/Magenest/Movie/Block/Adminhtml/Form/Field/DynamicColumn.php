<?php

namespace Magenest\Movie\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;

class DynamicColumn extends Select
{
    /**
     * SetInputName function
     *
     * @param [type] $value
     * @return void
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * SetInputId function
     *
     * @param [type] $value
     * @return void
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * GetSourceOptions function
     *
     * @return array
     */
    private function getSourceOptions()
    {
        return [
            ['label' => __('ALL GROUP'), 'value' => 0],
            ['label' => __('General'), 'value' => 1],
            ['label' => __('Wholesale'), 'value' => 2],
            ['label' => __('Retailer'), 'value' => 3],
        ];
    }
}
