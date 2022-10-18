<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Paypal\Model\System\Config\Source\PayLater;

/**
 * Source model for PayLater banner position
 */
class Position
{
    /**
     * PayLater positions source getter for Catalog Product Movie
     *
     * @return array
     */
    public function getPositionsCPP(): array
    {
        return [
            'header' => __('Header (center)'),
            'near_pp_button' => __('Under PayPal Checkout buttons')
        ];
    }

    /**
     * PayLater positions source getter for Home Movie
     *
     * @return array
     */
    public function getPositionsHP(): array
    {
        return [
            'header' => __('Header (center)'),
            'sidebar' => __('Sidebar')
        ];
    }

    /**
     * PayLater positions source getter for Checkout Movie
     *
     * @return array
     */
    public function getPositionsCheckout(): array
    {
        return [
            'near_pp_button' => __('Under PayPal Checkout buttons')
        ];
    }

    /**
     * PayLater positions source getter for Catalog Category Movie
     *
     * @return array
     */
    public function getPositionsCategoryPage(): array
    {
        return [
            'header' => __('Header (center)'),
            'sidebar' => __('Sidebar'),
        ];
    }

    /**
     * PayLater positions source getter for Checkout Cart Movie
     *
     * @return array
     */
    public function getPositionsCart(): array
    {
        return [
            'header' => __('Header (center)'),
            'near_pp_button' => __('Under PayPal Checkout buttons')
        ];
    }
}
