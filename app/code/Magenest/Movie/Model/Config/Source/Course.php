<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Course implements ArrayInterface
{
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'tints', 'label' => __('Tints')],
            ['value' => 'easing', 'label' => __('Easing')]
        ];
    }
}
