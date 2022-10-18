<?php

namespace Magenest\Movie\Model\ResourceModel\Actor;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Movie\Model\Actor;
use Magenest\Movie\Model\ResourceModel\Actor as ActorResourceModel;

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
