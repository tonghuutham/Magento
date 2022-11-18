<?php

namespace Magenest\Movie\Model\ResourceModel\Actor;

use Magenest\Movie\Model\Actor;
use Magenest\Movie\Model\ResourceModel\Actor as ActorResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Director Collection
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
        $this->_init(Actor::class, ActorResourceModel::class);
    }
}
