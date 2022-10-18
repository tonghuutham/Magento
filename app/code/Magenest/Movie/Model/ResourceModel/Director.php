<?php

namespace Magenest\Movie\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Director extends AbstractDb
{
    public function _construct()
    {
        $this->_init('magenest_director', 'director_id');
    }
}
