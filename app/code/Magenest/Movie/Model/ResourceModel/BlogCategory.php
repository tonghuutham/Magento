<?php

namespace Magenest\Movie\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BlogCategory extends AbstractDb
{
    public function _construct()
    {
        $this->_init('magenest_blog_category', 'blog_id');
    }
}
