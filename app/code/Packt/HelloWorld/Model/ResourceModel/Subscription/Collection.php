<?php

namespace Packt\HelloWorld\Model\ResourceModel\Subscription;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

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
        $this->_init('Packt\HelloWorld\Model\Subscription', 'Packt\HelloWorld\Model\ResourceModel\Subscription');
    }
}
