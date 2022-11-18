<?php

namespace Magenest\Movie\Model\ResourceModel\Category;

use Magenest\Movie\Model\Category;
use Magenest\Movie\Model\ResourceModel\Category as CategoryResourceModel;
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
        $this->_init(Category::class, CategoryResourceModel::class);
    }
}
