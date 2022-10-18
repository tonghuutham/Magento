<?php

namespace Magenest\Movie\Model\ResourceModel\Movie;

use Magenest\Movie\Model\Movie;
use Magenest\Movie\Model\ResourceModel\Movie as MovieResourceModel;
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
        $this->_init(Movie::class, MovieResourceModel::class);
    }





}
