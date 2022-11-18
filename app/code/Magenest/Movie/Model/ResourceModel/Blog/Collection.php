<?php

namespace Magenest\Movie\Model\ResourceModel\Blog;

use Magenest\Movie\Model\Blog;
use Magenest\Movie\Model\ResourceModel\Blog as BlogResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Blog Collection
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
        $this->_init(Blog::class, BlogResourceModel::class);
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->join(['au' => $this->getTable('admin_user')], 'au.user_id=main_table.author_id', );
    }
}
