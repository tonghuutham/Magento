<?php

namespace Magenest\Movie\Model\ResourceModel\MovieActor;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Movie\Model\MovieActor;
use Magenest\Movie\Model\ResourceModel\MovieActor as MovieActorResourceModel;

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
        $this->_init(MovieActor::class, MovieActorResourceModel::class);
    }
}
