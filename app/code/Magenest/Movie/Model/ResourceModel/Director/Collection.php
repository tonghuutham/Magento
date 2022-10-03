<?php

namespace Magenest\Movie\Model\ResourceModel\Director;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Movie\Model\Director;
use Magenest\Movie\Model\ResourceModel\Director;


/**
 * Subscription Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Magenest\Movie\Model\Subscription', 'Magenest\Movie\Model\ResourceModel\Subscription');
    }
}
