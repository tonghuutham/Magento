<?php

namespace Magenest\Movie\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MovieActor extends AbstractDb
{
    public function _construct()
    {
        $this->_init('magenest_movie_actor', 'entity_id');

    }
}
