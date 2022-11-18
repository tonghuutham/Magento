<?php

namespace Magenest\Movie\Model\ResourceModel\BlogCategory;

use Magenest\Movie\Model\BlogCategory;
use Magenest\Movie\Model\ResourceModel\Category as BlogCategoryResourceModel;
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
        $this->_init(BlogCategory::class, BlogCategoryResourceModel::class);
    }
}
