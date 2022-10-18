<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Paypal\Model\System\Config\Source;

class BmlPosition
{
    /**
     * Bml positions source getter for Home Movie
     *
     * @return array
     */
    public function getBmlPositionsHP()
    {
        return [
            '0' => __('Header (center)'),
            '1' => __('Sidebar (right)')
        ];
    }

    /**
     * Bml positions source getter for Catalog Category Movie
     *
     * @return array
     */
    public function getBmlPositionsCCP()
    {
        return [
            '0' => __('Header (center)'),
            '1' => __('Sidebar (right)')
        ];
    }

    /**
     * Bml positions source getter for Catalog Product Movie
     *
     * @return array
     */
    public function getBmlPositionsCPP()
    {
        return [
            '0' => __('Header (center)'),
            '1' => __('Near PayPal Credit checkout button')
        ];
    }

    /**
     * Bml positions source getter for Checkout Cart Movie
     *
     * @return array
     */
    public function getBmlPositionsCheckout()
    {
        return [
            '0' => __('Header (center)'),
            '1' => __('Near PayPal Credit checkout button')
        ];
    }
}
