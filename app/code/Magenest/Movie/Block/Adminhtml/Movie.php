<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Block\Adminhtml;

/**
 * adminhtml cms pages content block
 */
class Movie extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Block constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_page';
        $this->_blockGroup = 'Magenest_Movie';
        $this->_headerText = __('Manage Pages');

        parent::_construct();

        if ($this->_isAllowedAction('Magenest_Moive::save')) {
            $this->buttonList->update('add', 'label', __('Add New Movie'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
