<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Backend\Block\Dashboard;

/**
 * adminhtml dashboard grid
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 * @api
 * @since 100.0.2
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var string
     */
    protected $_template = 'Magento_Backend::dashboard/grid.phtml';

    /**
     * Setting default for every grid on dashboard
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setDefaultLimit(5);
    }
}
