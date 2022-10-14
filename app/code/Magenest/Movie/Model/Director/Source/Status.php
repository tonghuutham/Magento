<?php
namespace Magenest\Movie\Model\Employee\Source;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $emp;

    public function __construct(\Webkul\Hello\Model\Employee $emp)
    {
        $this->emp = $emp;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->getOptionArray();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }

    public static function getOptionArray()
    {
        return [1 => __('Enabled'), 0 => __('Disabled')];
    }
}
