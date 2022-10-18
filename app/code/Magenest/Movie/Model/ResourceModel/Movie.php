<?php

namespace Magenest\Movie\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Movie extends AbstractDb
{
    public function _construct()
    {
        $this->_init('magenest_movie', 'movie_id');
    }
}
