<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\Movie\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\DataObject;

/**
 *
 * Special Start Date attribute backend
 *
 * @api
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 * @since 100.0.2
 */
class Telephone extends AbstractBackend
{
    public function __construct()
    {
    }

    /**
     * Before save hook.
     * Prepare attribute value for save
     *
     * @param DataObject $object
     * @return $this
     */
    public function beforeSave($object)
    {
        $telephone = ($this->_getValueForSave($object));
        $phone = str_replace("+84", "0", $telephone);


        $object->setData($this->getAttribute()->getName(), $phone);
        parent::beforeSave($object);
        return $this;
    }

    /**
     * Get attribute value for save.
     *
     * @param DataObject $object
     * @return string|bool
     */
    protected function _getValueForSave($object)
    {
        $attributeName = $this->getAttribute()->getName();
        $telephone = $object->getData($attributeName);

        return $telephone;
    }


}
